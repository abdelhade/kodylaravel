@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>المبيعات والمشتريات</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('invoices.create', ['q' => 'sale']) }}" class="btn btn-primary btn-block mb-2">
                                فاتورة مبيعات
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('invoices.create', ['q' => 'buy']) }}" class="btn btn-success btn-block mb-2">
                                فاتورة مشتريات
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('invoices.create', ['q' => 'resale']) }}" class="btn btn-warning btn-block mb-2">
                                مردود مبيعات
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('invoices.create', ['q' => 'rebuy']) }}" class="btn btn-danger btn-block mb-2">
                                مردود مشتريات
                            </a>
                        </div>
                    </div>
                    <p class="text-muted mt-3">
                        <strong>ملاحظة:</strong> صفحة المبيعات معقدة وتحتوي على JavaScript متقدم. 
                        يتم استخدام LegacyController مؤقتاً حتى يتم تحويلها بالكامل.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
