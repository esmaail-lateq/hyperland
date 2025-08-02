<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MaerskService
{
    protected $apiKey;
    protected $baseUrl;
    protected $timeout;

    public function __construct()
    {
        // يمكن إضافة API key من ملف .env أو إعدادات الإدارة
        $this->apiKey = config('services.maersk.api_key', env('MAERSK_API_KEY'));
        $this->baseUrl = config('services.maersk.base_url', 'https://api.maersk.com');
        $this->timeout = config('services.maersk.timeout', 30);
    }

    /**
     * تتبع الحاوية أو الحجز
     */
    public function track(string $type, string $number): array
    {
        // التحقق من وجود API key
        if (empty($this->apiKey)) {
            throw new \Exception('API key غير مُعد. يرجى إضافة MAERSK_API_KEY في ملف .env');
        }

        // استخدام Cache لتجنب الطلبات المتكررة
        $cacheKey = "maersk_track_{$type}_{$number}";
        
        return Cache::remember($cacheKey, 300, function () use ($type, $number) {
            return $this->makeApiRequest($type, $number);
        });
    }

    /**
     * إجراء طلب API
     */
    private function makeApiRequest(string $type, string $number): array
    {
        try {
            $endpoint = $type === 'container' ? '/tracking/container' : '/tracking/booking';
            
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->get($this->baseUrl . $endpoint, [
                    'number' => $number
                ]);

            if ($response->successful()) {
                return $this->formatResponse($response->json(), $type);
            }

            // معالجة الأخطاء المختلفة
            if ($response->status() === 404) {
                throw new \Exception('لم يتم العثور على الشحنة. يرجى التحقق من الرقم.');
            }

            if ($response->status() === 401) {
                throw new \Exception('خطأ في المصادقة. يرجى التحقق من API key.');
            }

            if ($response->status() === 429) {
                throw new \Exception('تم تجاوز حد الطلبات. يرجى المحاولة لاحقاً.');
            }

            throw new \Exception('خطأ في الخادم: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('Maersk API Error', [
                'type' => $type,
                'number' => $number,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * تنسيق الاستجابة للعرض
     */
    private function formatResponse(array $data, string $type): array
    {
        // تنسيق عام للاستجابة
        $formatted = [
            'tracking_type' => $type,
            'tracking_number' => $data['number'] ?? '',
            'status' => $this->translateStatus($data['status'] ?? 'unknown'),
            'current_location' => $data['current_location'] ?? 'غير محدد',
            'expected_arrival' => $data['expected_arrival'] ?? 'غير محدد',
            'last_update' => $data['last_update'] ?? now()->format('Y-m-d H:i:s'),
            'movement_history' => $this->formatMovementHistory($data['movements'] ?? []),
            'container_info' => $data['container_info'] ?? [],
            'shipping_line' => 'Maersk'
        ];

        return $formatted;
    }

    /**
     * ترجمة حالة الشحنة
     */
    private function translateStatus(string $status): string
    {
        $statusMap = [
            'in_transit' => 'قيد النقل',
            'delivered' => 'تم التسليم',
            'arrived' => 'وصلت',
            'departed' => 'غادرت',
            'loading' => 'قيد التحميل',
            'discharging' => 'قيد التفريغ',
            'at_origin' => 'في نقطة البداية',
            'at_destination' => 'في نقطة الوصول',
            'unknown' => 'غير معروف'
        ];

        return $statusMap[$status] ?? $status;
    }

    /**
     * تنسيق سجل الحركة
     */
    private function formatMovementHistory(array $movements): array
    {
        $formatted = [];
        
        foreach ($movements as $movement) {
            $formatted[] = [
                'location' => $movement['location'] ?? 'غير محدد',
                'activity' => $this->translateActivity($movement['activity'] ?? ''),
                'timestamp' => $movement['timestamp'] ?? '',
                'status' => $this->translateStatus($movement['status'] ?? 'unknown')
            ];
        }

        return $formatted;
    }

    /**
     * ترجمة النشاط
     */
    private function translateActivity(string $activity): string
    {
        $activityMap = [
            'loaded' => 'تم التحميل',
            'discharged' => 'تم التفريغ',
            'departed' => 'غادرت',
            'arrived' => 'وصلت',
            'customs_clearance' => 'إجراءات جمركية',
            'inspection' => 'فحص',
            'waiting' => 'في انتظار'
        ];

        return $activityMap[$activity] ?? $activity;
    }

    /**
     * اختبار الاتصال بـ API
     */
    public function testConnection(): bool
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->get($this->baseUrl . '/health');

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Maersk API Connection Test Failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
} 