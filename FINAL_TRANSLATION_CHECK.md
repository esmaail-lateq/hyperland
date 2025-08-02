# البرومبت النهائي الشامل للبحث عن النصوص غير المترجمة

## 🎯 الهدف
البحث عن جميع النصوص المتبقية غير المترجمة في الموقع وإصلاحها نهائياً.

## 📋 البرومبت الشامل للبحث والإصلاح

### المرحلة الأولى: البحث الشامل عن النصوص غير المترجمة

```bash
# البحث عن النصوص العربية في جميع القوالب
grep -r ">[ء-ي ]*<" resources/views/ --include="*.blade.php" | grep -v "{{" | grep -v "}}" | grep -v "__("

# البحث عن النصوص الإنجليزية في جميع القوالب
grep -r ">[A-Za-z ]*<" resources/views/ --include="*.blade.php" | grep -v "{{" | grep -v "}}" | grep -v "__("

# البحث عن النصوص في Controllers
grep -r "قطع الغيار\|خدمات الشحن\|لوحة الإدارة\|إدارة المحتوى\|إدارة المستخدمين\|إضافة\|تعديل\|حذف\|عرض\|تفاصيل" app/Http/Controllers/

# البحث عن النصوص في Routes
grep -r "قطع الغيار\|خدمات الشحن\|لوحة الإدارة\|إدارة المحتوى\|إدارة المستخدمين" routes/

# البحث عن النصوص في Models
grep -r "قطع الغيار\|خدمات الشحن\|لوحة الإدارة\|إدارة المحتوى\|إدارة المستخدمين" app/Models/
```

### المرحلة الثانية: قائمة النصوص المطلوب ترجمتها

#### 1. في صفحة قطع الغيار (spare-parts/index.blade.php):
```php
// النصوص المطلوب ترجمتها:
- "إضافة قطع غيار جديدة" → {{ __('spare_parts.add_spare_part') }}
- "عرض التفاصيل" → {{ __('spare_parts.view_details') }}
- "لا توجد قطع غيار متاحة" → {{ __('spare_parts.no_spare_parts') }}
- "ابدأ بإضافة أول قطع غيار" → {{ __('spare_parts.start_adding') }}
- "إضافة قطع غيار" → {{ __('spare_parts.add_spare_part') }}
- "طلب قطع غيار مخصص" → {{ __('spare_parts.custom_request_title') }}
- "لا تجد ما تبحث عنه؟ أرسل لنا طلبك وسنحاول مساعدتك في العثور على قطع الغيار المطلوبة" → {{ __('spare_parts.custom_request_description') }}
- "وصف قطع الغيار التي تحتاجها" → {{ __('spare_parts.custom_request_form_description') }}
- "اكتب وصفاً مفصلاً لقطع الغيار التي تحتاجها..." → {{ __('spare_parts.custom_request_placeholder') }}
- "إرسال الطلب" → {{ __('spare_parts.send_request') }}
```

#### 2. في صفحة إضافة قطع الغيار (spare-parts/create.blade.php):
```php
// النصوص المطلوب ترجمتها:
- "إضافة قطعة غيار" → {{ __('spare_parts.add_spare_part') }}
- "أضف قطع الغيار التي تريد عرضها. سيتم مراجعة الطلب من قبل الإدارة قبل النشر" → {{ __('spare_parts.add_spare_part_description') }}
- "اسم قطعة الغيار" → {{ __('spare_parts.name') }}
- "اكتب وصفاً مفصلاً لقطعة الغيار..." → {{ __('spare_parts.description_placeholder') }}
- "حفظ" → {{ __('navigation.save') }}
- "إلغاء" → {{ __('navigation.cancel') }}
```

#### 3. في صفحة تعديل قطع الغيار (spare-parts/edit.blade.php):
```php
// النصوص المطلوب ترجمتها:
- "تعديل قطعة غيار" → {{ __('spare_parts.edit_spare_part') }}
- "قم بتحديث معلومات قطعة الغيار" → {{ __('spare_parts.edit_spare_part_description') }}
- "اسم قطعة الغيار" → {{ __('spare_parts.name') }}
- "اكتب وصفاً مفصلاً لقطعة الغيار..." → {{ __('spare_parts.description_placeholder') }}
- "تحديث" → {{ __('navigation.update') }}
- "إلغاء" → {{ __('navigation.cancel') }}
```

#### 4. في صفحة تفاصيل قطع الغيار (spare-parts/show.blade.php):
```php
// النصوص المطلوب ترجمتها:
- "قطع الغيار" → {{ __('spare_parts.spare_parts') }}
- "تفاصيل قطعة الغيار" → {{ __('spare_parts.spare_part_details') }}
- "العودة إلى قطع الغيار" → {{ __('spare_parts.back_to_spare_parts') }}
- "هل أنت متأكد من حذف قطعة الغيار هذه؟" → {{ __('spare_parts.confirm_delete') }}
```

#### 5. في صفحة خدمات الشحن (shipping/index.blade.php):
```php
// النصوص المطلوب ترجمتها:
- "تتبع شحناتك وحاوياتك بسهولة عبر Maersk مع معلومات محدثة في الوقت الفعلي" → {{ __('shipping.shipping_description') }}
- "تتبع الشحنة" → {{ __('shipping.track_container') }}
- "نوع التتبع" → {{ __('shipping.tracking_type') }}
- "رقم الحاوية" → {{ __('shipping.container_number') }}
- "رقم الحجز" → {{ __('shipping.booking_number') }}
- "رقم التتبع" → {{ __('shipping.tracking_number') }}
- "أدخل رقم الحاوية أو الحجز" → {{ __('shipping.tracking_number_placeholder') }}
- "تتبع الشحنة" → {{ __('shipping.track_container') }}
- "جاري البحث عن الشحنة..." → {{ __('shipping.searching_shipment') }}
- "حدث خطأ" → {{ __('shipping.error_occurred') }}
- "لم يتم العثور على الشحنة" → {{ __('shipping.shipment_not_found') }}
```

#### 6. في لوحة الإدارة (unified-cars/index.blade.php):
```php
// النصوص المطلوب ترجمتها:
- "تفاصيل قطع الغيار" → {{ __('spare_parts.spare_part_details') }}
- "هل أنت متأكد من حذف قطع الغيار هذه؟" → {{ __('spare_parts.confirm_delete') }}
```

### المرحلة الثالثة: تحديث ملفات الترجمة

#### 1. إضافة مفاتيح مفقودة إلى spare_parts.php:
```php
// إضافة إلى resources/lang/en/spare_parts.php
'view_details' => 'View Details',
'start_adding' => 'Start adding your first spare part.',
'custom_request_description' => 'Can\'t find what you\'re looking for? Send us your request and we\'ll try to help you find the required spare parts.',
'custom_request_form_description' => 'Describe the spare parts you need',
'custom_request_placeholder' => 'Write a detailed description of the spare parts you need...',
'send_request' => 'Send Request',
'booking_number' => 'Booking Number',
'tracking_type' => 'Tracking Type',
'searching_shipment' => 'Searching for shipment...',
'shipment_not_found' => 'Shipment not found',

// إضافة إلى resources/lang/ar/spare_parts.php
'view_details' => 'عرض التفاصيل',
'start_adding' => 'ابدأ بإضافة أول قطع غيار.',
'custom_request_description' => 'لا تجد ما تبحث عنه؟ أرسل لنا طلبك وسنحاول مساعدتك في العثور على قطع الغيار المطلوبة.',
'custom_request_form_description' => 'وصف قطع الغيار التي تحتاجها',
'custom_request_placeholder' => 'اكتب وصفاً مفصلاً لقطع الغيار التي تحتاجها...',
'send_request' => 'إرسال الطلب',
'booking_number' => 'رقم الحجز',
'tracking_type' => 'نوع التتبع',
'searching_shipment' => 'جاري البحث عن الشحنة...',
'shipment_not_found' => 'لم يتم العثور على الشحنة',
```

#### 2. إضافة مفاتيح مفقودة إلى shipping.php:
```php
// إضافة إلى resources/lang/en/shipping.php
'tracking_type' => 'Tracking Type',
'booking_number' => 'Booking Number',
'tracking_number_placeholder' => 'Enter container or booking number',
'searching_shipment' => 'Searching for shipment...',
'shipment_not_found' => 'Shipment not found',

// إضافة إلى resources/lang/ar/shipping.php
'tracking_type' => 'نوع التتبع',
'booking_number' => 'رقم الحجز',
'tracking_number_placeholder' => 'أدخل رقم الحاوية أو الحجز',
'searching_shipment' => 'جاري البحث عن الشحنة...',
'shipment_not_found' => 'لم يتم العثور على الشحنة',
```

### المرحلة الرابعة: تنفيذ التحديثات

#### 1. تحديث صفحة قطع الغيار:
```php
// في resources/views/spare-parts/index.blade.php
// تحديث جميع النصوص المذكورة أعلاه
```

#### 2. تحديث صفحة إضافة قطع الغيار:
```php
// في resources/views/spare-parts/create.blade.php
// تحديث جميع النصوص المذكورة أعلاه
```

#### 3. تحديث صفحة تعديل قطع الغيار:
```php
// في resources/views/spare-parts/edit.blade.php
// تحديث جميع النصوص المذكورة أعلاه
```

#### 4. تحديث صفحة تفاصيل قطع الغيار:
```php
// في resources/views/spare-parts/show.blade.php
// تحديث جميع النصوص المذكورة أعلاه
```

#### 5. تحديث صفحة خدمات الشحن:
```php
// في resources/views/shipping/index.blade.php
// تحديث جميع النصوص المذكورة أعلاه
```

### المرحلة الخامسة: اختبار شامل

#### 1. اختبار تبديل اللغة:
```bash
# اختبار تبديل إلى العربية
curl -I http://localhost/language/ar

# اختبار تبديل إلى الإنجليزية
curl -I http://localhost/language/en
```

#### 2. اختبار الصفحات:
```bash
# اختبار صفحة قطع الغيار
curl http://localhost/spare-parts

# اختبار صفحة خدمات الشحن
curl http://localhost/shipping

# اختبار لوحة الإدارة
curl http://localhost/unified-cars
```

#### 3. اختبار النصوص في tinker:
```php
php artisan tinker

// اختبار الترجمة
__('spare_parts.add_spare_part')
__('shipping.shipping_services')
__('admin.comprehensive_dashboard')
```

### المرحلة السادسة: مسح الكاش والتحقق النهائي

```bash
# مسح جميع أنواع الكاش
php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan route:clear

# التحقق من Routes
php artisan route:list --name=language

# التحقق من عدم وجود أخطاء
php artisan route:list
```

## 🚨 النصوص المطلوب إصلاحها فوراً

### 1. في صفحة قطع الغيار:
- ⏳ "إضافة قطع غيار جديدة"
- ⏳ "عرض التفاصيل"
- ⏳ "لا توجد قطع غيار متاحة"
- ⏳ "ابدأ بإضافة أول قطع غيار"
- ⏳ "طلب قطع غيار مخصص"
- ⏳ "لا تجد ما تبحث عنه؟ أرسل لنا طلبك..."

### 2. في صفحة إضافة/تعديل قطع الغيار:
- ⏳ "إضافة قطعة غيار"
- ⏳ "تعديل قطعة غيار"
- ⏳ "اسم قطعة الغيار"
- ⏳ "اكتب وصفاً مفصلاً لقطعة الغيار..."

### 3. في صفحة خدمات الشحن:
- ⏳ "تتبع شحناتك وحاوياتك بسهولة..."
- ⏳ "تتبع الشحنة"
- ⏳ "نوع التتبع"
- ⏳ "رقم الحاوية"
- ⏳ "رقم الحجز"
- ⏳ "رقم التتبع"
- ⏳ "أدخل رقم الحاوية أو الحجز"
- ⏳ "جاري البحث عن الشحنة..."
- ⏳ "حدث خطأ"
- ⏳ "لم يتم العثور على الشحنة"

### 4. في لوحة الإدارة:
- ⏳ "تفاصيل قطع الغيار"
- ⏳ "هل أنت متأكد من حذف قطع الغيار هذه؟"

## 📝 ملاحظات مهمة

### أفضل الممارسات:
1. **استخدام مفاتيح وصفية**: `spare_parts.add_spare_part` بدلاً من `add_part`
2. **تنظيم الملفات**: كل قسم له ملف ترجمة منفصل
3. **اختبار شامل**: التأكد من عمل الترجمة في كلا الاتجاهين
4. **مسح الكاش**: بعد كل تحديث

### الأخطاء الشائعة:
1. **نسيان إضافة الترجمة العربية**: يجب إضافة الترجمة للغتين
2. **عدم مسح الكاش**: قد لا تظهر التغييرات بدون مسح الكاش
3. **استخدام نصوص ثابتة**: يجب استخدام `{{ __('key') }}` دائماً

## 🎯 النتيجة المتوقعة

بعد تنفيذ هذا البرومبت:
- ✅ جميع النصوص في الموقع مترجمة
- ✅ تبديل سلس بين العربية والإنجليزية
- ✅ دعم كامل لـ RTL/LTR
- ✅ لا توجد نصوص ثابتة غير مترجمة
- ✅ اختبار شامل ومكتمل

---

**تاريخ الإنشاء**: {{ date('Y-m-d H:i:s') }}
**الحالة**: جاهز للتنفيذ ⏳ 