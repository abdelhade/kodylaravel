# دليل الاستخدام - موديول POS

## نظرة عامة
موديول POS يوفر نظام متكامل لإدارة نقاط البيع مع دعم الباركود والطاولات والشيفتات.

## الميزات الرئيسية

### 1. واجهة نقاط البيع الرئيسية
الوصول إلى الواجهة الرئيسية:
```
GET /pos
```

**الميزات:**
- عرض الطاولات المتاحة
- البحث عن الأصناف بالباركود
- إضافة الأصناف للطلب
- حساب الإجماليات والخصومات
- حفظ الطلب

**الاستخدام:**
1. اختر طاولة (اختياري)
2. أدخل الباركود أو الكود
3. أضف الأصناف للطلب
4. أدخل الخصم (اختياري)
5. اضغط "حفظ الطلب"

### 2. إدارة الطاولات

#### عرض قائمة الطاولات
```
GET /pos/tables
```

#### إضافة طاولة جديدة
```
GET /pos/tables/create
POST /pos/tables
```

**البيانات المطلوبة:**
```json
{
    "tname": "طاولة 1",
    "table_case": 0
}
```

#### تعديل طاولة
```
GET /pos/tables/{table}/edit
PUT /pos/tables/{table}
```

#### حذف طاولة
```
DELETE /pos/tables/{table}
```

#### تحديث حالة الطاولة (AJAX)
```
PATCH /pos/tables/{table}/status
```

**البيانات:**
```json
{
    "table_case": 1
}
```

**حالات الطاولة:**
- `0` - متاحة
- `1` - محجوزة
- `2` - صيانة

### 3. إدارة الشيفتات والجلسات المغلقة

#### عرض الجلسات المغلقة
```
GET /pos/closed-sessions
```

#### إغلاق الشيفت الحالي
```
POST /pos/close-shift
```

**العملية:**
1. يتم حساب مبيعات المستخدم الحالي لليوم
2. يتم إنشاء سجل إغلاق الشيفت
3. يتم تحديث حالة الطاولات

#### عرض تفاصيل جلسة
```
GET /pos/closed-sessions/{session}
```

#### تصدير الجلسات إلى Excel
```
GET /pos/closed-sessions/export/excel
```

### 4. البحث عن الأصناف

#### البحث بالباركود
```
POST /pos/search-item
```

**البيانات:**
```json
{
    "barcode": "123456"
}
```

**الرد:**
```json
{
    "id": 1,
    "aname": "اسم الصنف",
    "price": 100,
    "barcode": "123456"
}
```

### 5. إضافة صنف للطلب

```
POST /pos/add-item
```

**البيانات:**
```json
{
    "item_id": 1,
    "quantity": 2,
    "price": 100
}
```

**الرد:**
```json
{
    "item_id": 1,
    "item_name": "اسم الصنف",
    "quantity": 2,
    "price": 100,
    "total": 200
}
```

### 6. حفظ الطلب

```
POST /pos/save-order
```

**البيانات:**
```json
{
    "table_id": 1,
    "order_type": 1,
    "items": [
        {
            "item_id": 1,
            "quantity": 2,
            "price": 100
        }
    ],
    "total": 200,
    "discount": 10,
    "notes": "ملاحظات الطلب"
}
```

**الرد:**
```json
{
    "success": true,
    "order_id": 1,
    "message": "تم حفظ الطلب بنجاح"
}
```

## أمثلة عملية

### مثال 1: البحث عن صنف وإضافته للطلب

```javascript
// البحث عن الصنف
fetch('/pos/search-item', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({ barcode: '123456' })
})
.then(response => response.json())
.then(item => {
    // إضافة الصنف للطلب
    fetch('/pos/add-item', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            item_id: item.id,
            quantity: 1,
            price: item.price
        })
    })
    .then(response => response.json())
    .then(data => console.log('Item added:', data));
});
```

### مثال 2: حفظ طلب كامل

```javascript
const orderData = {
    table_id: 1,
    order_type: 1,
    items: [
        { item_id: 1, quantity: 2, price: 100 },
        { item_id: 2, quantity: 1, price: 50 }
    ],
    total: 250,
    discount: 25,
    notes: 'بدون بصل'
};

fetch('/pos/save-order', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify(orderData)
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Order saved:', data.order_id);
    }
});
```

### مثال 3: إدارة الطاولات

```javascript
// إضافة طاولة جديدة
const formData = new FormData();
formData.append('tname', 'طاولة 13');
formData.append('table_case', 0);

fetch('/pos/tables', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': token
    },
    body: formData
})
.then(response => response.json())
.then(data => console.log('Table added:', data));

// تحديث حالة الطاولة
fetch('/pos/tables/1/status', {
    method: 'PATCH',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({ table_case: 1 })
})
.then(response => response.json())
.then(data => console.log('Status updated:', data));
```

### مثال 4: إغلاق الشيفت

```javascript
fetch('/pos/close-shift', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': token
    }
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Shift closed:', data.message);
    }
});
```

## الإعدادات المتقدمة

### تخصيص أنواع الطلبات
يمكنك تخصيص أنواع الطلبات من خلال `config/config.php`:

```php
'order_types' => [
    1 => 'تيك أواي',
    2 => 'طاولة',
    3 => 'دليفري',
    4 => 'توصيل',
]
```

### تخصيص حالات الطاولات
```php
'table_statuses' => [
    0 => 'متاحة',
    1 => 'محجوزة',
    2 => 'صيانة',
    3 => 'مغلقة',
]
```

### تفعيل/تعطيل الميزات
```php
'settings' => [
    'enable_barcode_scanning' => true,
    'enable_table_management' => true,
    'enable_delivery' => true,
    'enable_takeaway' => true,
]
```

## الأخطاء الشائعة

### خطأ: "الصنف غير موجود"
**السبب:** الباركود غير صحيح أو الصنف محذوف
**الحل:** تحقق من الباركود وتأكد من وجود الصنف في قاعدة البيانات

### خطأ: "يجب إضافة صنف واحد على الأقل"
**السبب:** محاولة حفظ طلب بدون أصناف
**الحل:** أضف صنف واحد على الأقل قبل الحفظ

### خطأ: "حدث خطأ أثناء إغلاق الشيفت"
**السبب:** مشكلة في قاعدة البيانات أو الصلاحيات
**الحل:** تحقق من السجلات وتأكد من الصلاحيات

## نصائح الأداء

1. **استخدم الـ Caching** - قم بـ Cache الأصناف والإعدادات
2. **استخدم الـ Pagination** - قم بـ Paginate الجلسات المغلقة
3. **استخدم الـ Indexes** - أضف Indexes على الحقول المهمة
4. **استخدم الـ Transactions** - استخدم Transactions عند حفظ الطلبات

## الدعم والمساعدة

للمزيد من المعلومات:
- راجع `README.md` للنظرة العامة
- راجع `INSTALLATION.md` لخطوات التثبيت
- راجع `config/config.php` للإعدادات
