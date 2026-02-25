@extends('dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice"></i> تفاصيل السند
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('voucher.index') }}" class="btn btn-tool">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-hashtag"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">رقم السند</span>
                                    <span class="info-box-number">--</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">التاريخ</span>
                                    <span class="info-box-number">--</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">نوع السند</span>
                                    <span class="info-box-number">--</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">المبلغ</span>
                                    <span class="info-box-number">--</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info-circle"></i> البيان</h5>
                                <p>--</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <a href="{{ route('voucher.index') }}" class="btn btn-default">
                        <i class="fas fa-arrow-right"></i> رجوع
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
