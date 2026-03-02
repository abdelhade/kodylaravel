المجموعات

## الأصناف بدون مجموعة

الأصناف التي ليس لها مجموعة محددة تظهر تحت قسم "أصناف أخرى"

## ملاحظات

- يتم جلب المجموعات من جدول `acc_head` حيث `parent_id = 16`
- يتم ربط الأصناف بالمجموعات عبر حقل `group1` في جدول `myitems`
- التصميم responsive ويعمل على جميع الأجهزة
   $('.category-section').show();
        $('.item-wrapper').show();
    } else {
        $('.category-section').hide();
        $('.category-section[data-category-id="' + categoryId + '"]').show();
    }
});
```

### 4. تحسينات CSS

تم إضافة أنماط جديدة:
- تأثيرات hover على البطاقات
- رسوم متحركة عند الظهور
- تحسين المظهر العام

## كيفية الاستخدام

1. افتح واجهة POS: `/pos/barcode-basic` أو `/pos_barcode`
2. ستجد الأصناف مقسمة حسب مجموعاتها
3. استخدم أزرار التصنيفات في الأعلى للفلترة
4. زر "الكل" يعرض جميع  كل مجموعة
- تصميم منظم وجذاب

#### الميزات الجديدة:
- ✅ عرض اسم المجموعة مع أيقونة
- ✅ عداد عدد الأصناف في كل مجموعة
- ✅ فصل واضح بين المجموعات
- ✅ عرض الكمية المتوفرة من كل صنف
- ✅ تأثيرات hover جذابة
- ✅ رسوم متحركة عند التبديل بين المجموعات

### 3. تحديث JavaScript

تم تحديث كود الفلترة ليعمل مع التقسيم الجديد:

```javascript
$('.category-btn').click(function(e) {
    const categoryId = $(this).data('category');
    
    if (categoryId === 'all') {
           ->where('m.group1', $category->id)
        ->where('m.isdeleted', 0)
        ->select('m.*')
        ->orderBy('m.iname')
        ->get();
    
    if ($items->count() > 0) {
        $itemsByCategory[$category->id] = [
            'name' => $category->aname,
            'items' => $items
        ];
    }
}
```

### 2. تعديل barcode.blade.php

#### عرض الأصناف مقسمة:
- كل مجموعة لها عنوان خاص
- عداد لعدد الأصناف في 1. تعديل POSController.php

تم تحديث دالة `barcode()` لجلب الأصناف مقسمة حسب المجموعات:

```php
// جلب المجموعات مع الأصناف
$categories = DB::table('acc_head as cat')
    ->where('cat.parent_id', 16)
    ->where('cat.isdeleted', 0)
    ->select('cat.id', 'cat.aname')
    ->orderBy('cat.aname')
    ->get();

// جلب الأصناف مجمعة حسب المجموعات
$itemsByCategory = [];
foreach ($categories as $category) {
    $items = DB::table('myitems as m')
  # تحديث عرض الأصناف حسب المجموعات في POS

## التغييرات المطبقة

###