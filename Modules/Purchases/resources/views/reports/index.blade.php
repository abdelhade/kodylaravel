@extends('dashboard.layout')

@section('content')
<div class="container-fluid p-2">
    <h4 class="font-thin text-md text-white text-center"
        style="font-size:2em;padding:15px;background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);border-radius: 10px 10px 0 0;margin:0;">
        تقارير المشتريات
    </h4>

    <div class="card" style="border-radius: 0 0 10px 10px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('purchases.reports.daily') }}" class="btn btn-block btn-lg btn-outline-success" style="height: 150px;">
                        <h4>تقرير المشتريات اليومي</h4>
                        <i class="fas fa-calendar-day" style="font-size:50px;margin-top:10px;"></i>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('purchases.reports.items') }}" class="btn btn-block btn-lg btn-outline-info" style="height: 150px;">
                        <h4>تقرير المشتريات حسب الصنف</h4>
                        <i class="fas fa-boxes" style="font-size:50px;margin-top:10px;"></i>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('purchases.reports.suppliers') }}" class="btn btn-block btn-lg btn-outline-warning" style="height: 150px;">
                        <h4>تقرير المشتريات حسب المورد</h4>
                        <i class="fas fa-truck" style="font-size:50px;margin-top:10px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
