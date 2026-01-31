@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3>الشيفتات المغلقة</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>الشيفت</th>
                                    <th>التاريخ</th>
                                    <th>المستخدم</th>
                                    <th>وقت الانهاء</th>
                                    <th>اجمالي المبيعات</th>
                                    <th>المصاريف</th>
                                    <th>بيان المصاريف</th>
                                    <th>تسليم الكاش</th>
                                    <th>نهاية الدرج</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($closedSessions as $index => $session)
                                    <tr>
                                        <td>{{ $session->shift }}</td>
                                        <td>{{ $session->date }}</td>
                                        <td class="bg-primary text-white">{{ $session->user }}</td>
                                        <td>{{ $session->endtime }}</td>
                                        <td class="bg-success text-white">{{ number_format($session->total_sales ?? 0, 2) }}</td>
                                        <td class="bg-danger text-white">{{ number_format($session->expenses ?? 0, 2) }}</td>
                                        <td>{{ $session->exp_notes ?? '--' }}</td>
                                        <td class="bg-secondary text-white">{{ number_format($session->cash ?? 0, 2) }}</td>
                                        <td class="bg-light">{{ number_format($session->fund_after ?? 0, 2) }}</td>
                                        <td>{{ $session->info ?? '--' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">لا توجد شيفتات مغلقة</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
