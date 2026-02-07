@extends('dashboard.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">نظام المشتريات</h3>
                <small class="text-muted">إدارة فواتير المشتريات والمردودات</small>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                        <h5>فاتورة مشتريات</h5>
                        <p class="text-muted">إضافة فاتورة مشتريات جديدة</p>
                        <a href="{{ route('purchases.create', ['q' => 'buy']) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> إضافة
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-undo fa-3x text-warning mb-3"></i>
                        <h5>مردود مشتريات</h5>
                        <p class="text-muted">إضافة فاتورة مردود مشتريات</p>
                        <a href="{{ route('purchases.create', ['q' => 'rebuy']) }}" class="btn btn-warning">
                            <i class="fas fa-plus me-1"></i> إضافة
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-file-invoice fa-3x text-success mb-3"></i>
                        <h5>أمر شراء</h5>
                        <p class="text-muted">إنشاء أمر شراء جديد</p>
                        <a href="{{ route('purchases.create', ['q' => 'po']) }}" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i> إضافة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection