# موديول POS - نظام نقاط البيع

## نظرة عامة
موديول متكامل لإدارة نقاط البيع (POS) يتضمن:
- واجهة الكاشير الرئيسية مع البحث بالباركود
- إدارة الطاولات
- إدارة الشيفتات والجلسات المغلقة
- دعم أنواع طلبات متعددة (تيك أواي، طاولة، دليفري)

## الميزات الرئيسية

### 1. واجهة نقاط البيع
- البحث عن الأصناف بالباركود
- إضافة الأصناف للطلب مع حساب الكميات
- حساب الإجماليات والخصومات
- دعم ملء الشاشة (Fullscreen)
- واجهة سهلة الاستخدام

### 2. إدارة الطاولات
- إضافة وتعديل وحذف الطاولات
- تحديث حالة الطاولة (متاحة، محجوزة، صيانة)
- عرض الطاولات في شبكة تفاعلية

### 3. إدارة الشيفتات
- إغلاق الشيفت تلقائياً
- حساب مبيعات المستخدم
- عرض الجلسات المغلقة
- تصدير البيانات إلى Excel

## المسارات (Routes)

```
GET  /pos                              - واجهة POS الرئيسية
POST /pos/search-item                  - البحث عن صنف
POST /pos/add-item                     - إضافة صنف للطلب
POST /pos/save-order                   - حفظ الطلب

GET  /pos/tables                       - قائمة الطاولات
GET  /pos/tables/create                - نموذج إضافة طاولة
POST /pos/tables                       - حفظ طاولة جديدة
GET  /pos/tables/{table}/edit          - نموذج تعديل طاولة
PUT  /pos/tables/{table}               - تحديث طاولة
DELETE /pos/tables/{table}             - حذف طاولة
PATCH /pos/tables/{table}/status       - تحديث حالة الطاولة

GET  /pos/closed-sessions              - قائمة الجلسات المغلقة
POST /pos/close-shift                  - إغلاق الشيفت
GET  /pos/closed-sessions/{session}    - تفاصيل جلسة
GET  /pos/closed-sessions/export/excel - تصدير Excel
```

## الـ Controllers

### POSController
- `index()` - عرض واجهة POS الرئيسية
- `searchItem()` - البحث عن صنف بالباركود
- `addItem()` - إضافة صنف للطلب
- `saveOrder()` - حفظ الطلب

### TableController
- `index()` - عرض قائمة الطاولات
- `create()` - عرض نموذج إضافة طاولة
- `store()` - حفظ طاولة جديدة
- `edit()` - عرض نموذج تعديل طاولة
- `update()` - تحديث طاولة
- `destroy()` - حذف طاولة
- `updateStatus()` - تحديث حالة الطاولة

### ClosedSessionController
- `index()` - عرض قائمة الجلسات المغلقة
- `close()` - إغلاق الشيفت الحالي
- `show()` - عرض تفاصيل جلسة
- `export()` - تصدير البيانات إلى Excel

## الـ Models

### POSTable
- تمثيل جدول الطاولات
- Scopes: `active()`, `available()`
- Methods: `getStatusLabel()`

### ClosedSession
- تمثيل جدول الجلسات المغلقة
- Casts للحقول الرقمية والتواريخ

## الاستخدام

### 1. الوصول إلى واجهة POS
```
http://your-app.com/pos
```

### 2. البحث عن صنف
```javascript
fetch('/pos/search-item', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({ barcode: '123456' })
})
```

### 3. حفظ طلب
```javascript
fetch('/pos/save-order', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({
        table_id: 1,
        order_type: 1,
        items: [...],
        total: 100,
        discount: 10
    })
})
```

## الإعدادات

يمكن تخصيص الإعدادات من خلال ملف `config/config.php`:

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

## المتطلبات

- Laravel 12+
- PHP 8.2+
- قاعدة بيانات (MySQL, SQLite, etc.)

## التثبيت

1. تأكد من أن الموديول موجود في `Modules/POS`
2. قم بتشغيل الـ Migrations:
```bash
php artisan migrate
```

3. قم بتسجيل الموديول في `bootstrap/app.php` إذا لم يكن مسجلاً

## الترخيص

MIT License
