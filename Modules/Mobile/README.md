# 📱 Mobile Module

## نظرة عامة

موديول Mobile API كامل لتطبيقات الموبايل - يوفر API لتصفح المنتجات والمزيد.

## ✅ المميزات

- 🔐 Authentication (Laravel Sanctum)
- 📦 تصفح المنتجات
- 🔍 البحث والفلترة
- 📄 Pagination
- 💰 عرض الأسعار
- 🖼️ عرض الصور
- 📱 جاهز للاستخدام من Flutter/React Native

## 📂 البنية

```
Modules/Mobile/
├── app/
│   └── Http/
│       └── Controllers/
│           ├── MobileController.php (Dashboard)
│           └── Api/
│               ├── AuthController.php
│               └── ProductController.php
├── routes/
│   ├── web.php (Dashboard routes)
│   └── api.php (API routes)
├── resources/
│   └── views/
│       ├── index.blade.php (Dashboard)
│       └── docs.blade.php (Documentation)
└── module.json
```

## 🚀 API Endpoints

### Base URL
```
/api/mobile/v1
```

### Authentication
- `POST /auth/login` - تسجيل الدخول
- `POST /auth/logout` - تسجيل الخروج
- `GET /auth/me` - معلومات المستخدم

### Products (Public)
- `GET /products` - قائمة المنتجات
- `GET /products/{id}` - تفاصيل منتج
- `GET /categories` - التصنيفات
- `GET /groups` - المجموعات

## 📖 الوصول للتوثيق

### من Dashboard
1. سجل دخول
2. اذهب لـ "إدارة الموبايل"
3. اختر "لوحة التحكم" أو "التوثيق"

### الروابط المباشرة
- Dashboard: `/mobile`
- Documentation: `/mobile/docs`
- API Test: `/api/mobile/v1/products`

## 💻 أمثلة الاستخدام

### Flutter
```dart
import 'package:http/http.dart' as http;

Future<List<Product>> getProducts() async {
  final response = await http.get(
    Uri.parse('http://your-domain.com/api/mobile/v1/products'),
  );
  
  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    return (data['data'] as List)
        .map((item) => Product.fromJson(item))
        .toList();
  }
  throw Exception('Failed to load products');
}
```

### React Native
```javascript
const getProducts = async () => {
  const response = await fetch(
    'http://your-domain.com/api/mobile/v1/products'
  );
  const data = await response.json();
  return data.data;
};
```

## 🔧 التثبيت

الموديول مثبت ومفعل تلقائياً!

```bash
# التحقق من حالة الموديول
php artisan module:list

# تفعيل الموديول (إذا كان معطل)
php artisan module:enable Mobile
```

## 🧪 الاختبار

```bash
# تشغيل السيرفر
php artisan serve

# اختبار API
curl http://localhost:8000/api/mobile/v1/products
```

## 📊 الإحصائيات

- **Controllers**: 3
- **API Endpoints**: 8
- **Views**: 2
- **Authentication**: Laravel Sanctum
- **Status**: ✅ جاهز للإنتاج

## 🔜 التطوير المستقبلي

- [ ] Cart API
- [ ] Orders API
- [ ] Favorites API
- [ ] Reviews API
- [ ] Push Notifications
- [ ] Payment Gateway

## 📞 الدعم

للمساعدة:
- راجع التوثيق من Dashboard
- تحقق من `storage/logs/laravel.log`
- افتح issue في المشروع

---

**Version**: 1.0  
**Status**: ✅ Production Ready  
**Last Updated**: March 8, 2026
