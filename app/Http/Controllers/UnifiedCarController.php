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
        if (!auth()->user()->canApproveContent()) {
            abort(403, 'غير مصرح لك بالموافقة على المحتوى');
        }
        
        if ($car->approval_status !== 'pending') {
            return back()->with('error', 'يمكن الموافقة على السيارات في انتظار الموافقة فقط.');
        }
        
        $car->update(['approval_status' => 'approved']);
        
        // Send notification to car owner
        try {
            $car->user->notify(new \App\Notifications\CarApprovalNotification($car, auth()->user()));
            
            // Send notification to regular user if car owner is a regular user
            if ($car->user->isPublicUser()) {
                $car->user->notify(new \App\Notifications\UserCarApprovalNotification($car, auth()->user()));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send car approval notification: ' . $e->getMessage());
        }
        
        return back()->with('success', 'تم الموافقة على السيارة بنجاح!');
    }
    
    /**
     * Reject a car (admin only).
     */
    public function reject(Car $car)
    {
        if (!auth()->user()->canApproveContent()) {
            abort(403, 'غير مصرح لك بالموافقة على المحتوى');
        }
        
        if ($car->approval_status !== 'pending') {
            return back()->with('error', 'يمكن رفض السيارات في انتظار الموافقة فقط.');
        }
        
        $car->update(['approval_status' => 'rejected']);
        
        // Send notification to car owner
        try {
            $car->user->notify(new \App\Notifications\CarRejectionNotification($car, auth()->user()));
        } catch (\Exception $e) {
            \Log::error('Failed to send car rejection notification: ' . $e->getMessage());
        }
        
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
        
        $oldStatus = $car->status;
        $car->update(['status' => $request->status]);
        
        // TEMPORARY: Bypass rate limiting for testing
        $bypassRateLimit = true; // Set to false to enable rate limiting again
        
        // TEMPORARY: Disable aggregation for testing
        $bypassAggregation = true; // Set to false to enable aggregation again
        
        // Send notifications based on status change
        try {
            if ($request->status === 'sold') {
                \Log::info("=== CAR SOLD NOTIFICATION PROCESS START ===");
                \Log::info("Car ID: {$car->id}, Title: {$car->title}, User ID: {$car->user_id}");
                \Log::info("Current user ID: " . auth()->id());
                
                // Special notification for car sold
                $car->user->notify(new \App\Notifications\CarSoldNotification($car, auth()->user()));
                \Log::info("Sent notification to car owner (User ID: {$car->user_id})");
                
                // Send notification to all users (except the car owner and the one who changed the status)
                $allUsers = User::where('status', 'active')
                    ->where('id', '!=', $car->user_id)
                    ->whereNotNull('email_verified_at')
                    ->get();
                
                // Only exclude the user who changed the status if they are not an admin
                $currentUser = auth()->user();
                if ($currentUser && !$currentUser->isAdmin()) {
                    $allUsers = $allUsers->where('id', '!=', $currentUser->id);
                }
                
                // DEBUG: Log the users found
                \Log::info("Car sold notification - Found " . $allUsers->count() . " users to notify");
                foreach ($allUsers as $u) {
                    \Log::info("User to notify: ID={$u->id}, Name={$u->name}, Role={$u->role}");
                }
                    
                // Apply rate limiting and aggregation for car sold notifications
                foreach ($allUsers as $user) {
                    \Log::info("Processing user {$user->id} ({$user->name}) for car sold notification");
                    
                    if (!$bypassRateLimit && !\App\Services\NotificationRateLimiter::canSendNotification($user, 'car_sold')) {
                        \Log::info("Rate limit hit for user {$user->id} ({$user->name}) for car_sold notification");
                        continue;
                    }
                    
                    // Check if we should aggregate with existing notification
                    $shouldAggregate = !$bypassAggregation && \App\Services\NotificationAggregator::shouldAggregate($user, 'App\Notifications\CarSoldNotification');
                    \Log::info("Should aggregate for user {$user->id}: " . ($shouldAggregate ? 'YES' : 'NO'));
                    
                    if ($shouldAggregate) {
                        \Log::info("Aggregating notification for user {$user->id} ({$user->name})");
                        // Update existing notification
                        $existingNotification = \App\Services\NotificationAggregator::getRecentNotification($user, 'App\Notifications\CarSoldNotification');
                        
                        if ($existingNotification) {
                            \Log::info("Found existing notification ID: {$existingNotification->id} for user {$user->id}");
                            \App\Services\NotificationAggregator::updateExistingNotification($existingNotification, [
                                'id' => $car->id,
                                'title' => $car->title,
                                'type' => 'car_sold'
                            ]);
                            \Log::info("Updated existing notification for user {$user->id}");
                        } else {
                            \Log::warning("Should aggregate but no existing notification found for user {$user->id}");
                        }
                    } else {
                        \Log::info("Sending new notification to user {$user->id} ({$user->name})");
                        // Send new notification
                        $user->notify(new \App\Notifications\CarSoldNotification($car, auth()->user()));
                        \Log::info("Successfully sent new notification to user {$user->id}");
                    }
                }
                \Log::info("=== CAR SOLD NOTIFICATION PROCESS END ===");
            } elseif ($oldStatus !== $request->status) {
                \Log::info("=== CAR STATUS CHANGED NOTIFICATION PROCESS START ===");
                \Log::info("Car ID: {$car->id}, Title: {$car->title}, Old Status: {$oldStatus}, New Status: {$request->status}");
                
                // Regular status change notification
                $car->user->notify(new \App\Notifications\CarStatusChangedNotification($car, $request->status, $oldStatus, auth()->user()));
                \Log::info("Sent notification to car owner (User ID: {$car->user_id})");
                
                // Send notification to all users (except the car owner and the one who changed the status)
                $allUsers = User::where('status', 'active')
                    ->where('id', '!=', $car->user_id)
                    ->whereNotNull('email_verified_at')
                    ->get();
                
                // Only exclude the user who changed the status if they are not an admin
                $currentUser = auth()->user();
                if ($currentUser && !$currentUser->isAdmin()) {
                    $allUsers = $allUsers->where('id', '!=', $currentUser->id);
                }
                
                // DEBUG: Log the users found
                \Log::info("Car status changed notification - Found " . $allUsers->count() . " users to notify");
                foreach ($allUsers as $u) {
                    \Log::info("User to notify: ID={$u->id}, Name={$u->name}, Role={$u->role}");
                }
                    
                // Apply rate limiting and aggregation for status change notifications
                foreach ($allUsers as $user) {
                    \Log::info("Processing user {$user->id} ({$user->name}) for car status changed notification");
                    
                    if (!$bypassRateLimit && !\App\Services\NotificationRateLimiter::canSendNotification($user, 'car_status_changed')) {
                        \Log::info("Rate limit hit for user {$user->id} ({$user->name}) for car_status_changed notification");
                        continue;
                    }
                    
                    // Check if we should aggregate with existing notification
                    $shouldAggregate = !$bypassAggregation && \App\Services\NotificationAggregator::shouldAggregate($user, 'App\Notifications\CarStatusChangedNotification');
                    \Log::info("Should aggregate for user {$user->id}: " . ($shouldAggregate ? 'YES' : 'NO'));
                    
                    if ($shouldAggregate) {
                        \Log::info("Aggregating notification for user {$user->id} ({$user->name})");
                        // Update existing notification
                        $existingNotification = \App\Services\NotificationAggregator::getRecentNotification($user, 'App\Notifications\CarStatusChangedNotification');
                        
                        if ($existingNotification) {
                            \Log::info("Found existing notification ID: {$existingNotification->id} for user {$user->id}");
                            \App\Services\NotificationAggregator::updateExistingNotification($existingNotification, [
                                'id' => $car->id,
                                'title' => $car->title,
                                'type' => 'car_status'
                            ]);
                            \Log::info("Updated existing notification for user {$user->id}");
                        } else {
                            \Log::warning("Should aggregate but no existing notification found for user {$user->id}");
                        }
                    } else {
                        \Log::info("Sending new notification to user {$user->id} ({$user->name})");
                        // Send new notification
                        $user->notify(new \App\Notifications\CarStatusChangedNotification($car, $request->status, $oldStatus, auth()->user()));
                        \Log::info("Successfully sent new notification to user {$user->id}");
                    }
                }
                \Log::info("=== CAR STATUS CHANGED NOTIFICATION PROCESS END ===");
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send car status change notification: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
        }
        
        $statusText = $car->status_display;
        return back()->with('success', "تم تحديث حالة السيارة إلى: {$statusText}");
    }
    
    /**
     * Toggle featured status (admin only).
     */
    public function toggleFeatured(Car $car)
    {
        if (!auth()->user()->canApproveContent()) {
            abort(403, 'غير مصرح لك بالموافقة على المحتوى');
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
        if (!auth()->user()->canApproveContent()) {
            abort(403, 'غير مصرح لك بالموافقة على المحتوى');
        }
        
        if ($sparePart->approval_status !== 'pending') {
            return back()->with('error', 'يمكن الموافقة على قطع الغيار في انتظار الموافقة فقط.');
        }
        
        $sparePart->update(['approval_status' => 'approved']);
        
        // Send notification to spare part creator
        try {
            $sparePart->creator->notify(new \App\Notifications\SparePartApprovalNotification($sparePart, auth()->user()));
            
            // Send notification to regular user if spare part creator is a regular user
            if ($sparePart->creator->isPublicUser()) {
                $sparePart->creator->notify(new \App\Notifications\UserSparePartApprovalNotification($sparePart, auth()->user()));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send spare part approval notification: ' . $e->getMessage());
        }
        
        return back()->with('success', 'تم الموافقة على قطع الغيار بنجاح!');
    }
    
    /**
     * Reject a spare part (admin only).
     */
    public function rejectSparePart(SparePart $sparePart)
    {
        if (!auth()->user()->canApproveContent()) {
            abort(403, 'غير مصرح لك بالموافقة على المحتوى');
        }
        
        if ($sparePart->approval_status !== 'pending') {
            return back()->with('error', 'يمكن رفض قطع الغيار في انتظار الموافقة فقط.');
        }
        $sparePart->update(['approval_status' => 'rejected']);
        
        // Send notification to spare part creator
        try {
            $sparePart->creator->notify(new \App\Notifications\SparePartRejectionNotification($sparePart, auth()->user()));
        } catch (\Exception $e) {
            \Log::error('Failed to send spare part rejection notification: ' . $e->getMessage());
        }
        
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
