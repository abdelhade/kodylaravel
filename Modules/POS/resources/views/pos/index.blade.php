@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>نقاط البيع (POS)</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('pos.barcode') }}" class="btn btn-primary btn-lg btn-block mb-3">
                                <i class="fa fa-barcode"></i> نقطة البيع
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('pos.tables') }}" class="btn btn-success btn-lg btn-block mb-3">
                                <i class="fa fa-table"></i> إدارة الطاولات
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('pos.sessions') }}" class="btn btn-info btn-lg btn-block mb-3">
                                <i class="fa fa-clock"></i> الجلسات المغلقة
                            </a>
                        </div>
                    </div>
                    <p class="text-muted mt-3">
                        <strong>ملاحظة:</strong> صفحة POS معقدة جداً وتحتوي على:
                        <ul>
                            <li>Real-time barcode scanning</li>
                            <li>Table management system</li>
                            <li>Complex JavaScript interactions</li>
                            <li>Session management</li>
                            <li>Print functionality</li>
                        </ul>
                        يتم استخدام LegacyController مؤقتاً حتى يتم تحويلها بالكامل.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
