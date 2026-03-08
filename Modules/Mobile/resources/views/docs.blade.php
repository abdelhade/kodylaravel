@extends('dashboard.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-book mr-2"></i>
                        Mobile API - التوثيق الكامل
                    </h3>
                </div>
                <div class="card-body">
                    
                    <h4>📱 Base URL</h4>
                    <div class="alert alert-info">
                        <code>{{ url('/api/mobile/v1') }}</code>
                    </div>

                    <hr>

                    <h4>🔐 Authentication</h4>
                    
                    <h5 class="mt-3">Login</h5>
                    <p><span class="badge badge-primary">POST</span> <code>/auth/login</code></p>
                    
                    <h6>Request Body:</h6>
                    <pre class="bg-light p-3"><code>{
  "email": "user@example.com",
  "password": "password",
  "device_name": "iPhone 13"
}</code></pre>

                    <h6>Response:</h6>
                    <pre class="bg-light p-3"><code>{
  "success": true,
  "message": "تم تسجيل الدخول بنجاح",
  "data": {
    "token": "1|xxxxxxxxxxxxxxxx",
    "user": {
      "id": 1,
      "name": "أحمد محمد",
      "email": "user@example.com"
    }
  }
}</code></pre>

                    <hr>

                    <h4>📦 Products</h4>
                    
                    <h5 class="mt-3">Get All Products</h5>
                    <p><span class="badge badge-success">GET</span> <code>/products</code></p>
                    
                    <h6>Query Parameters:</h6>
                    <ul>
                        <li><code>per_page</code> - عدد المنتجات في الصفحة (default: 20)</li>
                        <li><code>page</code> - رقم الصفحة</li>
                        <li><code>search</code> - البحث في الاسم أو الكود</li>
                        <li><code>category_id</code> - فلترة حسب التصنيف</li>
                        <li><code>group_id</code> - فلترة حسب المجموعة</li>
                    </ul>

                    <h6>Example:</h6>
                    <pre class="bg-light p-3"><code>GET {{ url('/api/mobile/v1/products?per_page=10&page=1') }}</code></pre>

                    <h6>Response:</h6>
                    <pre class="bg-light p-3"><code>{
  "success": true,
  "data": [
    {
      "id": 1,
      "code": "123",
      "name": "قهوة تركية",
      "barcode": "6281234567890",
      "description": "قهوة فاخرة",
      "prices": {
        "wholesale": 45.50,
        "retail": 50.00,
        "market": 55.00,
        "cost": 40.00
      },
      "unit_name": "كيلو",
      "image_url": "http://domain.com/uploads/image.jpg"
    }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 10,
    "total": 50
  }
}</code></pre>

                    <hr>

                    <h5 class="mt-3">Get Single Product</h5>
                    <p><span class="badge badge-success">GET</span> <code>/products/{id}</code></p>
                    
                    <h6>Example:</h6>
                    <pre class="bg-light p-3"><code>GET {{ url('/api/mobile/v1/products/1') }}</code></pre>

                    <hr>

                    <h5 class="mt-3">Get Categories</h5>
                    <p><span class="badge badge-success">GET</span> <code>/categories</code></p>
                    
                    <h6>Example:</h6>
                    <pre class="bg-light p-3"><code>GET {{ url('/api/mobile/v1/categories') }}</code></pre>

                    <hr>

                    <h5 class="mt-3">Get Groups</h5>
                    <p><span class="badge badge-success">GET</span> <code>/groups</code></p>
                    
                    <h6>Example:</h6>
                    <pre class="bg-light p-3"><code>GET {{ url('/api/mobile/v1/groups') }}</code></pre>

                    <hr id="examples">

                    <h4>💻 أمثلة الكود</h4>

                    <h5 class="mt-3">Flutter Example</h5>
                    <pre class="bg-light p-3"><code>import 'package:http/http.dart' as http;
import 'dart:convert';

Future&lt;List&lt;Product&gt;&gt; getProducts() async {
  final response = await http.get(
    Uri.parse('{{ url('/api/mobile/v1/products') }}'),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    return (data['data'] as List)
        .map((item) => Product.fromJson(item))
        .toList();
  }
  throw Exception('Failed to load products');
}</code></pre>

                    <h5 class="mt-3">React Native Example</h5>
                    <pre class="bg-light p-3"><code>const getProducts = async () => {
  try {
    const response = await fetch(
      '{{ url('/api/mobile/v1/products') }}'
    );
    const data = await response.json();
    
    if (data.success) {
      return data.data;
    }
  } catch (error) {
    console.error('Error:', error);
  }
};</code></pre>

                    <div class="alert alert-success mt-4">
                        <h5><i class="fas fa-check-circle"></i> جاهز للاستخدام!</h5>
                        <p class="mb-0">يمكنك الآن البدء في تطوير تطبيق الموبايل والاتصال بالـ API</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
