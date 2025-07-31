<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // تأكد من وجود هذا الاستخدام إذا لم يكن موجودًا بالفعل

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public function index()
    {
        // جلب السيارات المميزة المعتمدة مع صورها (تحميل علاقة الصور لتجنب N+1 Query)
        $featuredCars = Car::with(['images'])
            ->where('is_featured', true)
            ->where('approval_status', 'approved') // عرض السيارات المعتمدة فقط
            ->whereIn('status', ['available', 'at_customs', 'in_transit', 'purchased', 'sold']) // عرض السيارات المتوفرة والمباعة
            ->latest()
            ->take(4) // جلب 4 سيارات مميزة
            ->get();

        // جلب أحدث السيارات المعتمدة مع صورها
        $latestCars = Car::with(['images'])
            ->where('approval_status', 'approved') // عرض السيارات المعتمدة فقط
            ->whereIn('status', ['available', 'at_customs', 'in_transit', 'purchased', 'sold']) // عرض السيارات المتوفرة والمباعة
            ->latest()
            ->take(6) // جلب 6 سيارات حديثة
            ->get();

        // جلب العدد الإجمالي للسيارات المعتمدة المعروضة
        $totalCarsCount = Car::where('approval_status', 'approved')
            ->whereIn('status', ['available', 'at_customs', 'in_transit', 'purchased', 'sold'])
            ->count();

        // **التعديل هنا: إضافة 'totalCarsCount' إلى compact()**
        return view('home', compact('featuredCars', 'latestCars', 'totalCarsCount'));
    }

    /**
     * Get latest cars for the API.
     */
    public function latestCars()
    {
        $cars = Car::with(['images'])
            ->where('approval_status', 'approved') // عرض السيارات المعتمدة فقط
            ->whereIn('status', ['available', 'at_customs', 'in_transit', 'purchased', 'sold']) // عرض السيارات المتوفرة والمباعة
            ->latest()
            ->take(6)
            ->get()
            ->map(function($car) {
                // البحث عن الصورة الأساسية أو أول صورة
                $primaryImage = $car->images->where('is_primary', true)->first() ?? $car->images->first();
                $imageUrl = $primaryImage ? Storage::url($primaryImage->image_path) : asset('images/default_car.jpg'); // استخدام asset() لمسار الصورة الافتراضية

                return [
                    'id' => $car->id,
                    'title' => $car->title,
                    'make' => $car->make,
                    'model' => $car->model,
                    'year' => $car->year,
                    'price' => $car->price,
                    'mileage' => $car->mileage,
                    'transmission' => ucfirst($car->transmission),
                    'image' => $imageUrl // استخدام المسار الفعلي أو الافتراضي
                ];
            });

        return response()->json(['cars' => $cars]);
    }
}