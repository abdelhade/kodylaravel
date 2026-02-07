# هيكل موديول POS

## البنية الكاملة للموديول

```
Modules/POS/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── POSController.php           # واجهة POS الرئيسية
│   │       ├── TableController.php         # إدارة الطاولات
│   │       └── ClosedSessionController.php # إدارة الجلسات المغلقة
│   ├── Models/
│   │   ├── POSTable.php                    # نموذج الطاولات
│   │   └── ClosedSession.php               # نموذج الجلسات المغلقة
│   └── Providers/
│       └── POSServiceProvider.php          # Service Provider
├── config/
│   └── config.php                          # إعدادات الموديول
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_pos_tables.php
│   │   └── 2024_01_01_000002_create_pos_orders_table.php
│   └── seeders/
│       └── POSSeeder.php                   # Seeder للبيانات التجريبية
├── resources/
│   ├── assets/
│   │   ├── css/
│   │   │   └── pos.css                     # أنماط POS
│   │   └── js/
│   │       └── pos.js                      # سكريبتات POS
│   └── views/
│       ├── pos/
│       │   └── index.blade.php             # واجهة POS الرئيسية
│       ├── tables/
│       │   ├── index.blade.php             # قائمة الطاولات
│       │   ├── create.blade.php            # نموذج إضافة طاولة
│       │   └── edit.blade.php              # نموذج تعديل طاولة
│       └── closed-sessions/
│           ├── index.blade.php             # قائمة الجلسات المغلقة
│           └── show.blade.php              # تفاصيل جلسة
├── routes/
│   └── web.php                             # المسارات
├── module.json                             # معلومات الموديول
├── composer.json                           # التبعيات
├── vite.config.js                          # إعدادات Vite
├── package.json                            # حزم NPM
├── README.md                               # دليل الاستخدام
├── INSTALLATION.md                         # دليل التثبيت
├── USAGE.md                                # أمثلة الاستخدام
└── STRUCTURE.md                            # هذا الملف
```

## وصف الملفات

### Controllers

#### POSController.php
**الوظيفة:** التحكم في واجهة POS الرئيسية
**الـ Methods:**
- `index()` - عرض واجهة POS
- `searchItem()` - البحث عن صنف بالباركود
- `addItem()` - إضافة صنف للطلب
- `saveOrder()` - حفظ الطلب

#### TableController.php
**الوظيفة:** إدارة الطاولات
**الـ Methods:**
- `index()` - عرض قائمة الطاولات
- `create()` - عرض نموذج إضافة طاولة
- `store()` - حفظ طاولة جديدة
- `edit()` - عرض نموذج تعديل طاولة
- `update()` - تحديث طاولة
- `destroy()` - حذف طاولة
- `updateStatus()` - تحديث حالة الطاولة

#### ClosedSessionController.php
**الوظيفة:** إدارة الجلسات المغلقة
**الـ Methods:**
- `index()` - عرض قائمة الجلسات المغلقة
- `close()` - إغلاق الشيفت الحالي
- `show()` - عرض تفاصيل جلسة
- `export()` - تصدير البيانات إلى Excel

### Models

#### POSTable.php
**الجدول:** `tables`
**الحقول:**
- `id` - معرف الطاولة
- `tname` - اسم الطاولة
- `table_case` - حالة الطاولة (0=متاحة، 1=محجوزة، 2=صيانة)
- `crtime` - وقت الإنشاء
- `mdtime` - وقت التعديل
- `isdeleted` - علم الحذف المنطقي
- `branch` - الفرع
- `tatnet` - حقل إضافي

**الـ Scopes:**
- `active()` - الطاولات غير المحذوفة
- `available()` - الطاولات المتاحة

**الـ Methods:**
- `getStatusLabel()` - الحصول على تسمية الحالة

#### ClosedSession.php
**الجدول:** `closed_orders`
**الحقول:**
- `id` - معرف السجل
- `shift` - رقم الشيفت
- `user` - اسم المستخدم
- `date` - تاريخ الشيفت
- `strttime` - وقت البداية
- `endtime` - وقت الانهاية
- `total_sales` - إجمالي المبيعات
- `delevery` - مبيعات الدليفري
- `tables` - مبيعات الطاولات
- `takeaway` - مبيعات التيك أواي
- `expenses` - المصاريف
- `fund_before` - رصيد الدرج قبل
- `fund_after` - رصيد الدرج بعد
- `exp_notes` - ملاحظات المصاريف
- `cash` - المبلغ المسلم
- `info` - ملاحظات
- `info2` - معلومات إضافية
- `tenant` - المستأجر
- `branch` - الفرع

### Views

#### pos/index.blade.php
**الوظيفة:** واجهة POS الرئيسية
**المحتوى:**
- عرض الطاولات في شبكة
- نموذج البحث عن الأصناف
- قائمة الأصناف المضافة
- حساب الإجماليات
- زر حفظ الطلب
- زر إغلاق الشيفت

#### tables/index.blade.php
**الوظيفة:** قائمة الطاولات
**المحتوى:**
- جدول بجميع الطاولات
- أزرار التعديل والحذف
- زر إضافة طاولة جديدة

#### tables/create.blade.php
**الوظيفة:** نموذج إضافة طاولة
**المحتوى:**
- حقل اسم الطاولة
- حقل الحالة
- أزرار الحفظ والإلغاء

#### tables/edit.blade.php
**الوظيفة:** نموذج تعديل طاولة
**المحتوى:**
- حقل اسم الطاولة (مملوء)
- حقل الحالة (مملوء)
- أزرار الحفظ والإلغاء

#### closed-sessions/index.blade.php
**الوظيفة:** قائمة الجلسات المغلقة
**المحتوى:**
- جدول بجميع الجلسات المغلقة
- أزرار العرض والتصدير
- Pagination

#### closed-sessions/show.blade.php
**الوظيفة:** تفاصيل جلسة مغلقة
**المحتوى:**
- معلومات الشيفت
- الإجماليات والمصاريف
- ملاحظات إضافية
- زر العودة

### Routes

**المسارات الرئيسية:**
```
GET  /pos                              - واجهة POS
POST /pos/search-item                  - البحث عن صنف
POST /pos/add-item                     - إضافة صنف
POST /pos/save-order                   - حفظ الطلب

GET  /pos/tables                       - قائمة الطاولات
GET  /pos/tables/create                - نموذج إضافة
POST /pos/tables                       - حفظ طاولة
GET  /pos/tables/{table}/edit          - نموذج تعديل
PUT  /pos/tables/{table}               - تحديث طاولة
DELETE /pos/tables/{table}             - حذف طاولة
PATCH /pos/tables/{table}/status       - تحديث الحالة

GET  /pos/closed-sessions              - قائمة الجلسات
POST /pos/close-shift                  - إغلاق الشيفت
GET  /pos/closed-sessions/{session}    - تفاصيل جلسة
GET  /pos/closed-sessions/export/excel - تصدير Excel
```

### Migrations

#### 2024_01_01_000001_create_pos_tables.php
**الجداول:**
- `tables` - جدول الطاولات
- `closed_orders` - جدول الجلسات المغلقة

#### 2024_01_01_000002_create_pos_orders_table.php
**الجداول:**
- `ot_head` - جدول رؤوس الطلبات
- `fat_details` - جدول تفاصيل الطلبات

### Assets

#### pos.css
**الأنماط:**
- أنماط الطاولات
- أنماط لوحة الطلب
- أنماط الأزرار
- أنماط الجداول
- أنماط الـ Responsive

#### pos.js
**الـ Functions:**
- `initPOS()` - تهيئة POS
- `initBarcodeScanner()` - تهيئة ماسح الباركود
- `searchItem()` - البحث عن صنف
- `addItemToOrder()` - إضافة صنف
- `updateOrderDisplay()` - تحديث عرض الطلب
- `saveOrder()` - حفظ الطلب
- `initFullscreen()` - تهيئة ملء الشاشة

## تدفق البيانات

### 1. البحث عن صنف
```
User Input (Barcode)
    ↓
POSController::searchItem()
    ↓
Database Query (acc_head)
    ↓
JSON Response
    ↓
JavaScript (pos.js)
    ↓
Display Item
```

### 2. إضافة صنف للطلب
```
User Click (Add Item)
    ↓
JavaScript (pos.js)
    ↓
POSController::addItem()
    ↓
Validation
    ↓
JSON Response
    ↓
Update Order Display
```

### 3. حفظ الطلب
```
User Click (Save Order)
    ↓
JavaScript (pos.js)
    ↓
POSController::saveOrder()
    ↓
Validation
    ↓
Database Transaction
    ↓
Insert ot_head
    ↓
Insert fat_details
    ↓
Update tables
    ↓
JSON Response
    ↓
Success Message
```

### 4. إغلاق الشيفت
```
User Click (Close Shift)
    ↓
ClosedSessionController::close()
    ↓
Calculate Sales
    ↓
Create ClosedSession Record
    ↓
Database Insert
    ↓
Redirect to Sessions List
```

## الأمان

### Authentication
- جميع المسارات محمية بـ `auth` middleware
- التحقق من تسجيل الدخول في كل Controller

### Authorization
- يمكن إضافة `authorize` middleware للتحقق من الصلاحيات
- استخدام Policy classes للتحكم الدقيق

### Validation
- Validation في كل Controller method
- استخدام Form Requests للـ Validation المتقدم

### CSRF Protection
- استخدام `@csrf` في جميع النماذج
- التحقق من CSRF token في الـ AJAX requests

## الأداء

### Caching
- يمكن إضافة Caching للأصناف والإعدادات
- استخدام Redis للـ Caching الموزع

### Database Optimization
- استخدام Indexes على الحقول المهمة
- استخدام Eager Loading للـ Relations

### Pagination
- استخدام Pagination للجلسات المغلقة
- تحديد عدد السجلات في كل صفحة

## التوسع المستقبلي

### ميزات مخطط لها
1. دعم الطباعة المباشرة
2. دعم الدفع الإلكتروني
3. دعم الفواتير الإلكترونية
4. دعم التقارير المتقدمة
5. دعم الـ Real-time Updates
6. دعم الـ Mobile App

### التحسينات المخطط لها
1. تحسين الأداء
2. تحسين الـ UI/UX
3. إضافة المزيد من الـ Tests
4. إضافة المزيد من الـ Logging
5. إضافة المزيد من الـ Validation
