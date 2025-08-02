<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\MaerskService;
use Illuminate\Http\JsonResponse;

class ShippingController extends Controller
{
    protected $maerskService;

    public function __construct(MaerskService $maerskService)
    {
        $this->maerskService = $maerskService;
    }

    /**
     * عرض صفحة خدمات الشحن
     */
    public function index(): View
    {
        return view('shipping.index');
    }

    /**
     * تتبع الحاوية أو الحجز
     */
    public function track(Request $request): JsonResponse
    {
        $request->validate([
            'tracking_type' => 'required|in:container,booking',
            'tracking_number' => 'required|string|max:50'
        ]);

        try {
            $trackingType = $request->input('tracking_type');
            $trackingNumber = trim($request->input('tracking_number'));

            // تنظيف وتطهير المدخلات
            $trackingNumber = $this->sanitizeTrackingNumber($trackingNumber);

            if (empty($trackingNumber)) {
                return response()->json([
                    'success' => false,
                    'message' => 'رقم التتبع غير صحيح'
                ], 400);
            }

            // استدعاء خدمة Maersk
            $result = $this->maerskService->track($trackingType, $trackingNumber);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تتبع الشحنة: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تنظيف وتطهير رقم التتبع
     */
    private function sanitizeTrackingNumber(string $number): string
    {
        // إزالة المسافات الزائدة والرموز غير المرغوبة
        $cleaned = preg_replace('/[^A-Z0-9]/', '', strtoupper($number));
        
        // التحقق من صحة التنسيق
        if (strlen($cleaned) < 4 || strlen($cleaned) > 20) {
            return '';
        }

        return $cleaned;
    }
} 