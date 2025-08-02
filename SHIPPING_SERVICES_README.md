# 🚢 خدمات الشحن - تتبع الحاويات

## 📋 نظرة عامة

تم إنشاء نظام خدمات الشحن المتكامل مع Maersk API لتتبع الحاويات والشحنات بسهولة وفعالية.

## 🎯 الميزات الرئيسية

### ✅ تتبع الحاويات
- **رقم الحاوية**: تتبع عبر رقم الحاوية المكون من 11 حرف
- **رقم الحجز**: تتبع عبر رقم الحجز المكون من 9 أرقام
- **معلومات شاملة**: حالة الشحنة، الموقع الحالي، تاريخ الوصول المتوقع

### ✅ واجهة مستخدم متقدمة
- **تصميم متجاوب**: يعمل على جميع الأجهزة
- **حالات مختلفة**: تحميل، خطأ، نتائج
- **سجل الحركة**: عرض تفصيلي لحركة الشحنة
- **معلومات الحاوية**: تفاصيل إضافية متاحة

### ✅ أمان وحماية
- **تنظيف المدخلات**: حماية من المدخلات الضارة
- **Rate Limiting**: حماية من الطلبات المفرطة
- **Cache**: تحسين الأداء وتقليل الطلبات

## 🛠️ الإعداد والتكوين

### 1. إضافة API Key

أضف المفاتيح التالية إلى ملف `.env`:

```env
# Maersk API Configuration
MAERSK_API_KEY=your_api_key_here
MAERSK_BASE_URL=https://api.maersk.com
MAERSK_TIMEOUT=30
```

### 2. الحصول على API Key

1. قم بزيارة [Maersk Developer Portal](https://developer.maersk.com)
2. أنشئ حساب مطور جديد
3. اطلب API key للوصول إلى خدمات التتبع
4. أضف المفتاح إلى ملف `.env`

## 📁 هيكل الملفات

```
app/
├── Http/Controllers/
│   └── ShippingController.php          # Controller الرئيسي
├── Services/
│   └── MaerskService.php              # خدمة Maersk API
└── Providers/
    └── MaerskServiceProvider.php      # Service Provider

resources/views/
└── shipping/
    └── index.blade.php                # صفحة خدمات الشحن

config/
└── services.php                       # إعدادات Maersk

routes/
└── web.php                           # Routes الجديدة
```

## 🔧 الاستخدام

### الوصول للصفحة
```
GET /shipping
```

### تتبع الشحنة
```
POST /shipping/track
Content-Type: application/json

{
    "tracking_type": "container|booking",
    "tracking_number": "ABCD1234567"
}
```

## 📊 استجابة API

### استجابة ناجحة
```json
{
    "success": true,
    "data": {
        "tracking_type": "container",
        "tracking_number": "ABCD1234567",
        "status": "قيد النقل",
        "current_location": "ميناء جدة",
        "expected_arrival": "2024-01-15",
        "last_update": "2024-01-10 14:30:00",
        "movement_history": [
            {
                "location": "ميناء شنغهاي",
                "activity": "تم التحميل",
                "timestamp": "2024-01-08 10:00:00",
                "status": "تم التحميل"
            }
        ],
        "container_info": {
            "size": "40ft",
            "type": "Dry Container"
        },
        "shipping_line": "Maersk"
    }
}
```

### استجابة خطأ
```json
{
    "success": false,
    "message": "لم يتم العثور على الشحنة. يرجى التحقق من الرقم."
}
```

## 🎨 التصميم والمظهر

### الألوان المستخدمة
- **الأزرق الأساسي**: `bg-blue-600` للعناصر الرئيسية
- **الأزرق الفاتح**: `bg-blue-50` للخلفية
- **الأحمر**: `bg-red-50` لحالات الخطأ
- **الأخضر**: `bg-green-100` للحالات الناجحة

### العناصر التفاعلية
- **أزرار**: تأثيرات hover و focus
- **حقول الإدخال**: تحقق من صحة المدخلات
- **حالات التحميل**: مؤشرات بصرية
- **رسائل الخطأ**: واضحة ومفيدة

## 🔒 الأمان

### حماية المدخلات
```php
// تنظيف رقم التتبع
private function sanitizeTrackingNumber(string $number): string
{
    $cleaned = preg_replace('/[^A-Z0-9]/', '', strtoupper($number));
    
    if (strlen($cleaned) < 4 || strlen($cleaned) > 20) {
        return '';
    }
    
    return $cleaned;
}
```

### Rate Limiting
- **Cache**: 5 دقائق لكل طلب
- **Timeout**: 30 ثانية للاتصال
- **Validation**: تحقق من صحة المدخلات

## 🚀 التحسينات المستقبلية

### ميزات مقترحة
1. **تتبع متعدد**: تتبع عدة حاويات في نفس الوقت
2. **إشعارات**: إشعارات عند تغيير حالة الشحنة
3. **تقارير**: تقارير مفصلة عن الشحنات
4. **خرائط**: عرض مواقع الشحنات على الخرائط
5. **API عام**: وصول خارجي للخدمات

### تحسينات تقنية
1. **Webhooks**: استقبال تحديثات تلقائية
2. **Queue**: معالجة الطلبات في الخلفية
3. **Analytics**: إحصائيات الاستخدام
4. **Multi-language**: دعم لغات إضافية

## 🐛 استكشاف الأخطاء

### مشاكل شائعة

#### 1. خطأ في API Key
```
خطأ في المصادقة. يرجى التحقق من API key.
```
**الحل**: تأكد من صحة API key في ملف `.env`

#### 2. خطأ في الاتصال
```
حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.
```
**الحل**: تحقق من اتصال الإنترنت وإعدادات Firewall

#### 3. رقم تتبع غير صحيح
```
لم يتم العثور على الشحنة. يرجى التحقق من الرقم.
```
**الحل**: تأكد من صحة رقم الحاوية أو الحجز

### سجلات الأخطاء
```bash
# عرض سجلات Laravel
docker exec -it laravel_app tail -f storage/logs/laravel.log

# عرض سجلات Maersk API
grep "Maersk API Error" storage/logs/laravel.log
```

## 📞 الدعم

### معلومات الاتصال
- **المطور**: فريق التطوير
- **البريد الإلكتروني**: support@example.com
- **التوثيق**: [Maersk API Documentation](https://developer.maersk.com/docs)

### روابط مفيدة
- [Maersk Developer Portal](https://developer.maersk.com)
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)

---

**تم التطوير بواسطة فريق Auto-Market** 🚗📦 