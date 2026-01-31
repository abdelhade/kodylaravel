@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>
                        @if($type == 'sale') فاتورة مبيعات
                        @elseif($type == 'buy') فاتورة مشتريات
                        @elseif($type == 'resale') مردود مبيعات
                        @elseif($type == 'rebuy') مردود مشتريات
                        @elseif($type == 'po') أمر شراء
                        @elseif($type == 'so') أمر بيع
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <strong>ملاحظة:</strong> صفحة الفواتير معقدة جداً وتحتوي على:
                        <ul>
                            <li>JavaScript متقدم للتفاعلات</li>
                            <li>Barcode scanning</li>
                            <li>Real-time calculations</li>
                            <li>Complex invoice elements</li>
                        </ul>
                        يتم استخدام LegacyController مؤقتاً حتى يتم تحويلها بالكامل.
                    </p>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">رجوع</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
