# دليل التثبيت - موديول POS

## المتطلبات
- Laravel 12+
- PHP 8.2+
- قاعدة بيانات (MySQL, SQLite, PostgreSQL, etc.)
- Composer

## خطوات التثبيت

### 1. التحقق من وجود الموديول
تأكد من أن مجلد `Modules/POS` موجود في المشروع.

### 2. تسجيل الموديول (إذا لم يكن مسجلاً)
تأكد من أن الموديول مسجل في `bootstrap/app.php`:

```php
use Nwidart\Modules\Facades\Module;

Module::register([
    'Modules/POS',
]);
```

### 3. تشغيل الـ Migrations
```bash
php artisan migrate
```

هذا سيقوم بإنشاء الجداول التالية:
- `tables` - جدول الطاولات
- `closed_orders` - جدول الجلسات المغلقة
- `ot_head` - جدول رؤوس الطلبات
- `fat_details` - جدول تفاصيل الطلبات

### 4. تشغيل الـ Seeders (اختياري)
```bash
php artisan db:seed --class="Modules\\POS\\Database\\Seeders\\POSSeeder"
```

هذا سيقوم بإضافة 12 طاولة تجريبية.

### 5. نشر الـ Assets (اختياري)
```bash
php artisan vendor:publish --tag=pos-assets
```

## التحقق من التثبيت

### 1. التحقق من الـ Routes
```bash
php artisan route:list | grep pos
```

يجب أن ترى المسارات التالية:
- `GET /pos`
- `GET /pos/tables`
- `GET /pos/closed-sessions`
- إلخ...

### 2. الوصول إلى واجهة POS
افتح المتصفح وانتقل إلى:
```
http://your-app.com/pos
```

### 3. التحقق من قاعدة البيانات
```bash
php artisan tinker
```

ثم قم بتشغيل:
```php
DB::table('tables')->count()
DB::table('closed_orders')->count()
```

## استكشاف الأخطاء

### المشكلة: الموديول لا يتم تحميله
**الحل:**
1. تأكد من أن مجلد `Modules/POS` موجود
2. تأكد من أن `module.json` موجود في المجلد
3. قم بتشغيل: `php artisan module:enable POS`

### المشكلة: الـ Routes لا تعمل
**الحل:**
1. امسح الـ Cache: `php artisan route:clear`
2. امسح الـ Config Cache: `php artisan config:clear`
3. قم بتشغيل: `php artisan route:cache`

### المشكلة: الـ Views لا تظهر
**الحل:**
1. تأكد من أن مجلد `resources/views` موجود
2. امسح الـ View Cache: `php artisan view:clear`
3. تأكد من أن `POSServiceProvider` يحمل الـ Views بشكل صحيح

### المشكلة: الـ Migrations لم تعمل
**الحل:**
1. تأكد من أن جداول قاعدة البيانات لم تُنشأ بالفعل
2. قم بتشغيل: `php artisan migrate:refresh`
3. تحقق من ملفات الـ Migrations في `database/migrations`

## الإعدادات الإضافية

### تخصيص الإعدادات
يمكنك تخصيص إعدادات الموديول من خلال ملف `config/config.php`:

```php
'settings' => [
    'enable_barcode_scanning' => true,
    'enable_table_management' => true,
    'enable_delivery' => true,
    'enable_takeaway' => true,
    'default_order_type' => 1,
    'auto_close_shift' => true,
    'shift_close_time' => '23:59:59',
]
```

### إضافة Middleware مخصص
يمكنك إضافة Middleware مخصص للتحقق من الصلاحيات:

```php
Route::middleware(['auth', 'pos.permission'])->group(function () {
    // Routes
});
```

## الخطوات التالية

1. **تخصيص الـ Views** - قم بتخصيص الـ Views حسب احتياجاتك
2. **إضافة Validation** - أضف Validation مخصص للنماذج
3. **إضافة Logging** - أضف Logging للعمليات المهمة
4. **إضافة Tests** - أضف Unit Tests و Feature Tests
5. **تحسين الأداء** - أضف Caching و Optimization

## الدعم والمساعدة

للمزيد من المعلومات، راجع:
- `README.md` - دليل الاستخدام
- `config/config.php` - الإعدادات
- `routes/web.php` - المسارات
- `app/Http/Controllers/` - Controllers

## الترخيص

MIT License
