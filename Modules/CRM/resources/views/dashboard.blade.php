@extends('dashboard.layout')

@section('content')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>📊 لوحة تحكم CRM</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- إحصائيات سريعة -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalLeads }}</h3>
                            <p>إجمالي العملاء المحتملين</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('leads.index') }}" class="small-box-footer">
                            المزيد <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $newLeads }}</h3>
                            <p>عملاء جدد</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="{{ route('leads.index') }}" class="small-box-footer">
                            المزيد <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalOpportunities }}</h3>
                            <p>الفرص البيعية</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="{{ route('opportunities.index') }}" class="small-box-footer">
                            المزيد <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($totalOpportunitiesValue, 2) }}</h3>
                            <p>قيمة الفرص</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="{{ route('opportunities.index') }}" class="small-box-footer">
                            المزيد <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- أحدث العملاء المحتملين -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">أحدث العملاء المحتملين</h3>
                            <div class="card-tools">
                                <a href="{{ route('leads.index') }}" class="btn btn-sm btn-primary">
                                    عرض الكل
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>المصدر</th>
                                        <th>الحالة</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentLeads as $lead)
                                    <tr>
                                        <td>{{ $lead->name }}</td>
                                        <td>{{ $lead->source_name ?? '-' }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $lead->status_color ?? '#6c757d' }}">
                                                {{ $lead->status_name ?? 'غير محدد' }}
                                            </span>
                                        </td>
                                        <td>{{ date('Y-m-d', strtotime($lead->created_at)) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">لا توجد بيانات</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">أحدث الفرص البيعية</h3>
                            <div class="card-tools">
                                <a href="{{ route('opportunities.index') }}" class="btn btn-sm btn-primary">
                                    عرض الكل
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>العنوان</th>
                                        <th>العميل</th>
                                        <th>المرحلة</th>
                                        <th>القيمة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOpportunities as $opportunity)
                                    <tr>
                                        <td>{{ $opportunity->title }}</td>
                                        <td>{{ $opportunity->lead_name ?? '-' }}</td>
                                        <td>{{ $opportunity->stage_name ?? '-' }}</td>
                                        <td>{{ number_format($opportunity->amount, 2) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">لا توجد بيانات</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- إحصائيات الأنشطة -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">الأنشطة</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-tasks"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">إجمالي الأنشطة</span>
                                            <span class="info-box-number">{{ $totalActivities }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-calendar-day"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">أنشطة اليوم</span>
                                            <span class="info-box-number">{{ $todayActivities }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('activities.index') }}" class="btn btn-primary">
                                عرض جميع الأنشطة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
