@extends('layouts.master')

@section('title', 'الجلسات المغلقة')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>الشيفتات المغلقة</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('pos.closed-sessions.export') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-download me-1"></i>تصدير Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($sessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>الشيفت</th>
                                <th>التاريخ</th>
                                <th>المستخدم</th>
                                <th>وقت الانهاء</th>
                                <th>إجمالي المبيعات</th>
                                <th>المصاريف</th>
                                <th>ملاحظات المصاريف</th>
                                <th>تسليم الكاش</th>
                                <th>نهاية الدرج</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                                <tr>
                                    <td>{{ $session->shift }}</td>
                                    <td>{{ $session->date->format('Y-m-d') }}</td>
                                    <td class="bg-primary text-white">{{ $session->user }}</td>
                                    <td>{{ $session->endtime }}</td>
                                    <td class="bg-success text-white">{{ number_format($session->total_sales, 2) }}</td>
                                    <td class="bg-danger text-white">{{ number_format($session->expenses, 2) }}</td>
                                    <td>{{ $session->exp_notes }}</td>
                                    <td class="bg-secondary text-white">{{ number_format($session->cash, 2) }}</td>
                                    <td class="bg-light">{{ number_format($session->fund_after, 2) }}</td>
                                    <td>
                                        <a href="{{ route('pos.closed-sessions.show', $session) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $sessions->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>لا توجد جلسات مغلقة حتى الآن
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
