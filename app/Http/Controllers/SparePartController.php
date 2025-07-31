<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SparePartController extends Controller
{
    /**
     * Display a listing of approved spare parts.
     */
    public function index()
    {
        $spareParts = SparePart::with('creator')
            ->where('approval_status', 'approved')
            ->latest()
            ->paginate(12);

        return view('spare-parts.index', compact('spareParts'));
    }

    /**
     * Show the form for creating a new spare part.
     */
    public function create()
    {
        return view('spare-parts.create');
    }

    /**
     * Store a newly created spare part.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $images = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('spare-parts', 'public');
                $images[] = $path;
            }
        }

        $sparePart = SparePart::create([
            'name' => $request->name,
            'description' => $request->description,
            'images' => $images,
            'approval_status' => 'pending',
            'created_by' => Auth::id()
        ]);

        return redirect()->route('spare-parts.show', $sparePart)
            ->with('success', 'تم إرسال طلب قطع الغيار بنجاح! سيتم مراجعته من قبل الإدارة.');
    }

    /**
     * Display the specified spare part.
     */
    public function show(SparePart $sparePart)
    {
        return view('spare-parts.show', compact('sparePart'));
    }

    /**
     * Show the form for editing the specified spare part.
     */
    public function edit(SparePart $sparePart)
    {
        // Check if user can edit this spare part
        if (Auth::id() !== $sparePart->created_by && !Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح لك بتعديل هذا الجزء.');
        }

        return view('spare-parts.edit', compact('sparePart'));
    }

    /**
     * Update the specified spare part.
     */
    public function update(Request $request, SparePart $sparePart)
    {
        // Check if user can edit this spare part
        if (Auth::id() !== $sparePart->created_by && !Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح لك بتعديل هذا الجزء.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $images = $sparePart->images ?? [];
        
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
            
            // Store new images
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('spare-parts', 'public');
                $images[] = $path;
            }
        }

        $sparePart->update([
            'name' => $request->name,
            'description' => $request->description,
            'images' => $images,
        ]);

        return redirect()->route('spare-parts.show', $sparePart)
            ->with('success', 'تم تحديث قطع الغيار بنجاح!');
    }

    /**
     * Remove the specified spare part.
     */
    public function destroy(SparePart $sparePart)
    {
        // Check if user can delete this spare part
        if (Auth::id() !== $sparePart->created_by && !Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح لك بحذف هذا الجزء.');
        }

        // Delete images
        if ($sparePart->images) {
            foreach ($sparePart->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $sparePart->delete();

        return redirect()->route('spare-parts.index')
            ->with('success', 'تم حذف قطع الغيار بنجاح!');
    }

    /**
     * Submit a custom spare part request.
     */
    public function requestCustom(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000'
        ]);

        // Here you could create a separate table for custom requests
        // For now, we'll create a spare part with pending status
        $sparePart = SparePart::create([
            'name' => 'طلب مخصص: ' . substr($request->description, 0, 50) . '...',
            'description' => $request->description,
            'images' => [],
            'approval_status' => 'pending',
            'created_by' => Auth::id()
        ]);

        return redirect()->route('spare-parts.index')
            ->with('success', 'تم إرسال طلب قطع الغيار المخصص بنجاح! سيتم مراجعته من قبل الإدارة.');
    }
}
