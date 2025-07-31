<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\SparePart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class UnifiedCarController extends Controller
{
    /**
     * Display the unified car listings page with admin/user controls.
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'cars'); // 'cars' or 'spare-parts'
        
        if ($type === 'spare-parts') {
            return $this->sparePartsIndex($request);
        }
        
        return $this->carsIndex($request);
    }
    
    /**
     * Display the unified spare parts listings page with admin/user controls.
     */
    public function sparePartsIndex(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        
        // Build the query
        $query = SparePart::with(['creator']);
        
        // If not admin, only show user's spare parts
        if (!$isAdmin) {
            $query->where('created_by', $user->id);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Approval status filter
        if ($request->filled('approval_status') && $request->approval_status !== 'all') {
            $query->where('approval_status', $request->approval_status);
        }
        
        // Creator filter (admin only)
        if ($isAdmin && $request->filled('creator')) {
            $query->where('created_by', $request->creator);
        }
        
        $spareParts = $query->latest()->paginate(15);
        
        // Get creators for admin filter
        $creators = $isAdmin ? User::whereHas('spareParts')->get() : collect();
        
        // Get status counts for current user or all (for admin)
        $statusCounts = $this->getSparePartsStatusCounts($isAdmin ? null : $user->id);
        
        // Initialize empty variables for cars section
        $cars = collect();
        $years = collect();
        $advertisers = collect();
        
        return view('unified-cars.index', compact(
            'spareParts', 
            'creators', 
            'statusCounts', 
            'isAdmin',
            'cars',
            'years',
            'advertisers'
        ));
    }
    
    /**
     * Display the unified car listings page with admin/user controls.
     */
    public function carsIndex(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        
        // Build the query
        $query = Car::with(['user', 'images']);
        
        // If not admin, only show user's cars
        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        // Approval status filter
        if ($request->filled('approval_status') && $request->approval_status !== 'all') {
            $query->where('approval_status', $request->approval_status);
        }
        
        // Car status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Year filter
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        
        // Year range filter
        if ($request->filled('year_from') && $request->filled('year_to')) {
            $query->whereBetween('year', [$request->year_from, $request->year_to]);
        }
        
        // Advertiser filter (admin only)
        if ($isAdmin && $request->filled('advertiser')) {
            $query->where('user_id', $request->advertiser);
        }
        
        $cars = $query->latest()->paginate(15);
        
        // Get unique years for filter
        $years = Car::distinct()->pluck('year')->sort()->values();
        
        // Get advertisers for admin filter
        $advertisers = $isAdmin ? User::whereHas('cars')->get() : collect();
        
        // Get status counts for current user or all (for admin)
        $statusCounts = $this->getStatusCounts($isAdmin ? null : $user->id);
        
        // Initialize empty variables for spare parts section
        $spareParts = collect();
        $creators = collect();
        
        return view('unified-cars.index', compact(
            'cars', 
            'years', 
            'advertisers', 
            'statusCounts', 
            'isAdmin',
            'spareParts',
            'creators'
        ));
    }
    
    /**
     * Approve a car (admin only).
     */
    public function approve(Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($car->approval_status !== 'pending') {
            return back()->with('error', 'يمكن الموافقة على السيارات في انتظار الموافقة فقط.');
        }
        
        $car->update(['approval_status' => 'approved']);
        
        return back()->with('success', 'تم الموافقة على السيارة بنجاح!');
    }
    
    /**
     * Reject a car (admin only).
     */
    public function reject(Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($car->approval_status !== 'pending') {
            return back()->with('error', 'يمكن رفض السيارات في انتظار الموافقة فقط.');
        }
        
        $car->update(['approval_status' => 'rejected']);
        
        return back()->with('success', 'تم رفض السيارة بنجاح!');
    }
    
    /**
     * Update car status based on user permissions.
     */
    public function updateStatus(Request $request, Car $car)
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        
        // Check permissions
        if (!$isAdmin && $car->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate status based on user type
        $allowedStatuses = $isAdmin 
            ? ['available', 'at_customs', 'in_transit', 'purchased', 'sold']
            : ['sold']; // Regular users can only mark as sold
        
        $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', $allowedStatuses)]
        ]);
        
        $car->update(['status' => $request->status]);
        
        $statusText = $car->status_display;
        return back()->with('success', "تم تحديث حالة السيارة إلى: {$statusText}");
    }
    
    /**
     * Toggle featured status (admin only).
     */
    public function toggleFeatured(Car $car)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $car->update(['is_featured' => !$car->is_featured]);
        
        $status = $car->is_featured ? 'مميزة' : 'غير مميزة';
        return back()->with('success', "تم تحديث حالة السيارة إلى: {$status}");
    }
    
    /**
     * Get status counts for filtering.
     */
    private function getStatusCounts($userId = null)
    {
        $query = Car::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return [
            'all' => $query->count(),
            'pending' => (clone $query)->where('approval_status', 'pending')->count(),
            'approved' => (clone $query)->where('approval_status', 'approved')->count(),
            'rejected' => (clone $query)->where('approval_status', 'rejected')->count(),
            'available' => (clone $query)->where('status', 'available')->count(),
            'at_customs' => (clone $query)->where('status', 'at_customs')->count(),
            'in_transit' => (clone $query)->where('status', 'in_transit')->count(),
            'purchased' => (clone $query)->where('status', 'purchased')->count(),
            'sold' => (clone $query)->where('status', 'sold')->count(),
        ];
    }
    
    /**
     * Approve a spare part (admin only).
     */
    public function approveSparePart(SparePart $sparePart)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($sparePart->approval_status !== 'pending') {
            return back()->with('error', 'يمكن الموافقة على قطع الغيار في انتظار الموافقة فقط.');
        }
        
        $sparePart->update(['approval_status' => 'approved']);
        
        return back()->with('success', 'تم الموافقة على قطع الغيار بنجاح!');
    }
    
    /**
     * Reject a spare part (admin only).
     */
    public function rejectSparePart(SparePart $sparePart)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($sparePart->approval_status !== 'pending') {
            return back()->with('error', 'يمكن رفض قطع الغيار في انتظار الموافقة فقط.');
        }
        
        $sparePart->update(['approval_status' => 'rejected']);
        
        return back()->with('success', 'تم رفض قطع الغيار بنجاح!');
    }
    
    /**
     * Get spare parts status counts for filtering.
     */
    private function getSparePartsStatusCounts($userId = null)
    {
        $query = SparePart::query();
        
        if ($userId) {
            $query->where('created_by', $userId);
        }
        
        return [
            'all' => $query->count(),
            'pending' => (clone $query)->where('approval_status', 'pending')->count(),
            'approved' => (clone $query)->where('approval_status', 'approved')->count(),
            'rejected' => (clone $query)->where('approval_status', 'rejected')->count(),
        ];
    }
}
