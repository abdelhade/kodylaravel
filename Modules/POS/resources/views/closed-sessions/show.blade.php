@extends('layouts.master')

@section('title', 'تفاصيل الجلسة المغلقة')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>تفاصيل الشيفت</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>رقم الشيفت:</strong> {{ $session->shift }}
                        </div>
                        <div class="col-md-6">
                            <strong>التاريخ:</strong> {{ $session->date->format('Y-m-d') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>المستخدم:</strong> {{ $session->user }}
                        </div>
                        <div class="col-md-6">
                            <strong>وقت الانهاء:</strong> {{ $session->endtime }}
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>إجمالي المبيعات:</strong>
                            <span class="badge bg-success">{{ number_format($session->total_sales, 2) }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>المصاريف:</strong>
                            <span class="badge bg-danger">{{ number_format($session->expenses, 2) }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>تسليم الكاش:</strong>
                            <span class="badge bg-secondary">{{ number_format($session->cash, 2) }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>نهاية الدرج:</strong>
                            <span class="badge bg-light text-dark">{{ number_format($session->fund_after, 2) }}</span>
                        </div>
                    </div>

                    @if($session->exp_notes)
                        <div class="mb-3">
                            <strong>ملاحظات المصاريف:</strong>
                            <p class="text-muted">{{ $session->exp_notes }}</p>
                        </div>
                    @endif

                    @if($session->info)
                        <div class="mb-3">
                            <strong>ملاحظات إضافية:</strong>
                            <p class="text-muted">{{ $session->info }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>معلومات إضافية</h5>
                </div>
                <div class="card-body">
                    <p><strong>الفرع:</strong> {{ $session->branch }}</p>
                    <p><strong>المستأجر:</strong> {{ $session->tenant }}</p>
                    <p><strong>نوع الإغلاق:</strong> {{ $session->info2 }}</p>
                    <p><strong>تاريخ الإنشاء:</strong> {{ $session->created_at->format('Y-m-d H:i:s') }}</p>
                    <p><strong>آخر تعديل:</strong> {{ $session->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('pos.closed-sessions.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-arrow-left me-1"></i>العودة
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
