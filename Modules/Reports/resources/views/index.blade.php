@extends('dashboard.layout')

@section('content')
    <div class="container-fluid ح-2">
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
                <div class="mb-4">
                    <h5 class="text-primary mb-3">
                        🛠️ تقارير عقارية
                    </h5>
                    <div class="row g-3 justify-content-center" id="rentalReportsContent">
                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-primary btn-sm w-100" href="{{ route('rents.index') }}">
                                🏢 تقرير الوحدات الإيجارية
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-secondary btn-sm w-100"
                                href="{{ url('/legacy/rentcontracts?del=0') }}">
                                📄 قائمة العقود
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-danger btn-sm w-100" href="{{ url('/legacy/rentcontracts?del=1') }}">
                                ❌ العقود المنتهية
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-warning btn-sm w-100" href="{{ route('rents.installments') }}">
                                💰 الأقساط المستحقة
                            </a>
                        </div>
                    </div>
                </div>

                <!-- التقارير المالية -->
                <div class="mb-4">
                    <h5 class="text-success mb-3">
                        💰 تقارير مالية
                    </h5>
                    <div class="row g-3 justify-content-center" id="financialReportsContent">
                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-success btn-sm w-100"
                                href="{{ route('acc-report.index', ['acc' => 'clients']) }}">
                                👥 تقرير العملاء
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-info btn-sm w-100" href="{{ url('/legacy/top_products_report') }}">
                                📊 تقرير الأصناف الأكثر مبيعًا
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-primary btn-sm w-100" href="{{ route('reports.summary') }}">
                                📋 كشف حساب
                            </a>
                        </div>
                    </div>
                </div>

                <!-- التقارير الإدارية -->
                <div class="mb-4">
                    <h5 class="text-info mb-3">
                        📋 تقارير إدارية
                    </h5>
                    <div class="row g-3 justify-content-center" id="adminReportsContent">
                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-info btn-sm w-100" href="{{ url('/legacy/attendance_report') }}">
                                🕒 تقرير الحضور والانصراف
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-3 report-item">
                            <a class="btn btn-outline-dark btn-sm w-100" href="{{ url('/legacy/staff_report') }}">
                                👨‍💼 تقرير الموظفين
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted text-center">
                <small>آخر تحديث: {{ date('Y-m-d H:i') }}</small>
            </div>
        </div>
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
