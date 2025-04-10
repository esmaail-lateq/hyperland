<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarImageController extends Controller
{
    /**
     * Delete a car image.
     */
    public function destroy(CarImage $image)
    {
        $car = $image->car;
        
        // Authorize the user to edit this car's images
        $this->authorize('update', $car);
        
        // Check if this is the only image
        if ($car->images()->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete the only image. Please upload a new image first.'
            ], 422);
        }
        
        // Get image details before deletion
        $wasDeleted = Storage::disk('public')->delete($image->image_path);
        $wasPrimary = $image->is_primary;
        $displayOrder = $image->display_order;
        
        // Delete the image record
        $image->delete();
        
        // If deleted image was primary, set the first remaining image as primary
        if ($wasPrimary) {
            $car->images()->first()->update(['is_primary' => true]);
        }
        
        // Reorder remaining images
        $car->images()
            ->where('display_order', '>', $displayOrder)
            ->decrement('display_order');
        
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
    
    /**
     * Set an image as primary.
     */
    public function setPrimary(CarImage $image)
    {
        $car = $image->car;
        
        // Authorize the user to edit this car's images
        $this->authorize('update', $car);
        
        // Set all images as non-primary
        $car->images()->update(['is_primary' => false]);
        
        // Set selected image as primary
        $image->update(['is_primary' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Primary image set successfully'
        ]);
    }
    
    /**
     * Reorder images.
     */
    public function reorder(Request $request, Car $car)
    {
        // Authorize the user to edit this car's images
        $this->authorize('update', $car);
        
        $request->validate([
            'imageIds' => 'required|array',
            'imageIds.*' => 'integer|exists:car_images,id'
        ]);
        
        // Update the order of images
        foreach ($request->imageIds as $index => $imageId) {
            CarImage::where('id', $imageId)
                ->where('car_id', $car->id)
                ->update(['display_order' => $index]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Images reordered successfully'
        ]);
    }
} 