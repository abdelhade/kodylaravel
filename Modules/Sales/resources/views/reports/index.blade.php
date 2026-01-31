@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">تقارير المبيعات</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('sales-reports.by-day') }}" class="btn btn-block btn-lg btn-outline-success">
                                <h2>المبيعات اليومية</h2>
                                <br>
                                <i class="fa fa-calendar-day" style="font-size:60px;"></i>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('items_summery') }}" class="btn btn-block btn-lg btn-outline-success">
                                <h2>المبيعات أصناف</h2>
                                <br>
                                <i class="fa fa-boxes" style="font-size:60px;"></i>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('sales-reports.by-hour') }}" class="btn btn-block btn-lg btn-outline-success">
                                <h2>المبيعات بالساعة</h2>
                                <br>
                                <i class="fa fa-clock" style="font-size:60px;"></i>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('sales-reports.by-day') }}" class="btn btn-block btn-lg btn-outline-success">
                                <h2>المبيعات باليوم</h2>
                                <br>
                                <i class="fa fa-calendar-alt" style="font-size:60px;"></i>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('sales-reports.by-week') }}" class="btn btn-block btn-lg btn-outline-success">
                                <h2>المبيعات بالأسبوع</h2>
                                <br>
                                <i class="fa fa-calendar-week" style="font-size:60px;"></i>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('sales-reports.by-month') }}" class="btn btn-block btn-lg btn-outline-success">
                                <h2>المبيعات بالشهر</h2>
                                <br>
                                <i class="fa fa-calendar" style="font-size:60px;"></i>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('top_products_report') }}" class="btn btn-block btn-lg btn-outline-success">
                                <h2>تحليلي مبيعات</h2>
                                <br>
                                <i class="fa fa-chart-line" style="font-size:60px;"></i>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('stagnant_items_report') }}" class="btn btn-block btn-lg btn-outline-warning">
                                <h2>الأصناف الراكدة</h2>
                                <br>
                                <i class="fa fa-exclamation-triangle" style="font-size:60px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
