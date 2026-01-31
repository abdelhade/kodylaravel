@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post">
                    @csrf
                    <div class="card-header">
                        <h1>المبيعات أسبوعياً</h1>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">من:</label>
                                    <input type="date" name="from" value="{{ old('from', $from) }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">إلى:</label>
                                    <input type="date" name="to" value="{{ old('to', $to) }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">بحث</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card-body">
                    @if($count_weeks > 0)
                    <!-- إحصائيات فوق -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="alert alert-success">
                                <b>أعلى أسبوع:</b> {{ $max_week->week_start }} → {{ $max_week->week_end }}<br>
                                {{ number_format($max_week->total_sales, 2) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-danger">
                                <b>أقل أسبوع:</b> {{ $min_week->week_start }} → {{ $min_week->week_end }}<br>
                                {{ number_format($min_week->total_sales, 2) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-info">
                                <b>متوسط الأسبوع:</b><br>
                                {{ number_format($avg_week, 2) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-warning">
                                <b>الإجمالي الكلي:</b><br>
                                {{ number_format($grand_total, 2) }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- جدول المبيعات -->
                    <div class="table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>من</th>
                                    <th>إلى</th>
                                    <th>إجمالي المبيعات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($weeks as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->week_start }}</td>
                                        <td>{{ $row->week_end }}</td>
                                        <td>{{ number_format($row->total_sales, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">لا توجد بيانات</td>
                                    </tr>
                                @endforelse

                                @if($weeks->count() > 0)
                                <tr style="font-weight: bold; background: #f0f0f0;">
                                    <td colspan="3" class="text-center">الإجمالي الكلي</td>
                                    <td>{{ number_format($grand_total, 2) }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
