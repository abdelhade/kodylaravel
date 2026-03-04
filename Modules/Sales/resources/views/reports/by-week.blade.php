@extends('dashboard.layout')

@section('content')
<div class="container-fluid p-2">
    <h4 class="font-thin text-md text-white text-center"
        style="font-size:2em;padding:15px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius: 10px 10px 0 0;margin:0;">
        المبيعات الأسبوعية
    </h4>

    <div class="card" style="border-radius: 0 0 10px 10px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-body p-4">
            <form action="" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">من:</label>
                            <input type="date" name="from" class="form-control" value="{{ old('from', $from) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">إلى:</label>
                            <input type="date" name="to" class="form-control" value="{{ old('to', $to) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label style="visibility: hidden;">بحث</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            @if ($count_weeks > 0)
                <!-- إحصائيات فوق -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="alert alert-success text-center">
                            <h5><i class="fas fa-arrow-up"></i> أعلى أسبوع</h5>
                            <h4>{{ number_format($max_week->total_sales, 2) }}</h4>
                            <p class="mb-0">{{ $max_week->week_start }} → {{ $max_week->week_end }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="alert alert-danger text-center">
                            <h5><i class="fas fa-arrow-down"></i> أقل أسبوع</h5>
                            <h4>{{ number_format($min_week->total_sales, 2) }}</h4>
                            <p class="mb-0">{{ $min_week->week_start }} → {{ $min_week->week_end }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="alert alert-info text-center">
                            <h5><i class="fas fa-chart-line"></i> متوسط الأسبوع</h5>
                            <h4>{{ number_format($avg_week, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="alert alert-warning text-center">
                            <h5><i class="fas fa-calculator"></i> الإجمالي الكلي</h5>
                            <h4>{{ number_format($grand_total, 2) }}</h4>
                        </div>
                    </div>
                </div>
            @endif

            <!-- جدول المبيعات -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
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

                        @if ($weeks->count() > 0)
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
@endsection
