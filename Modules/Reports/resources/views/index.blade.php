@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h3 class="mb-0">📊 تقارير {{ $title }}</h3>
                </div>

                <div class="card-body">
                    <!-- إضافة خانة البحث -->
                    <div class="mb-3">
                        <input type="text" id="reportSearch" class="form-control" placeholder="بحث في التقارير..." />
                    </div>

                    <!-- التقارير العقارية -->
                    <h5 class="text-primary mb-3">
                        <button class="btn btn-link text-primary" data-bs-toggle="collapse" data-bs-target="#rentalReports" aria-expanded="true" aria-controls="rentalReports">
                            🛠️ تقارير عقارية
                        </button>
                    </h5>
                    <div id="rentalReports" class="collapse show">
                        <div class="row g-3 justify-content-center" id="rentalReportsContent">
                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-primary btn-block btn-sm w-100" href="{{ route('rentables.index') }}">
                                    🏢 تقرير الوحدات الإيجارية
                                </a>
                            </div>

                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-secondary btn-block btn-sm w-100" href="{{ route('rentcontracts.index', ['del' => 0]) }}">
                                    📄 قائمة العقود
                                </a>
                            </div>

                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-danger btn-block btn-sm w-100" href="{{ route('rentcontracts.index', ['del' => 1]) }}">
                                    ❌ العقود المنتهية
                                </a>
                            </div>

                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-warning btn-block btn-sm w-100" href="{{ route('myrentables.index') }}">
                                    💰 الأقساط المستحقة
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- التقارير المالية -->
                    <h5 class="text-success mb-3">
                        <button class="btn btn-link text-success" data-bs-toggle="collapse" data-bs-target="#financialReports" aria-expanded="true" aria-controls="financialReports">
                            💰 تقارير مالية
                        </button>
                    </h5>
                    <div id="financialReports" class="collapse show">
                        <div class="row g-3 justify-content-center" id="financialReportsContent">
                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-success btn-block btn-sm w-100" href="{{ route('acc-report.index', ['acc' => 'clients']) }}">
                                    👥 تقرير العملاء
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-info btn-block btn-sm w-100" href="{{ route('top_products_report') }}">
                                    📊 تقرير الأصناف الأكثر مبيعًا
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-primary btn-block btn-sm w-100" href="{{ route('reports.summary') }}">
                                    📋 كشف حساب
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- التقارير الإدارية -->
                    <h5 class="text-info mb-3">
                        <button class="btn btn-link text-info" data-bs-toggle="collapse" data-bs-target="#adminReports" aria-expanded="true" aria-controls="adminReports">
                            📋 تقارير إدارية
                        </button>
                    </h5>
                    <div id="adminReports" class="collapse show">
                        <div class="row g-3 justify-content-center" id="adminReportsContent">
                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-info btn-block btn-sm w-100" href="{{ route('attendance_report') }}">
                                    🕒 تقرير الحضور والانصراف
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 report-item">
                                <a class="btn btn-outline-dark btn-block btn-sm w-100" href="{{ route('staff_report') }}">
                                    👨‍💼 تقرير الموظفين
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted text-center">
                    <small>آخر تحديث: {{ date("Y-m-d H:i") }}</small>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript للتصفية حسب البحث -->
<script>
    document.getElementById('reportSearch').addEventListener('input', function(e) {
        var searchQuery = e.target.value.toLowerCase();
        document.querySelectorAll('.report-item').forEach(item => {
            item.style.display = item.innerText.toLowerCase().includes(searchQuery) ? 'block' : 'none';
        });
    });
</script>
@endsection
