@extends('dashboard.layout')

@section('content')
<div class="container-fluid p-2">
    <h4 class="font-thin text-md text-white text-center"
        style="font-size:2em;padding:15px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius: 10px 10px 0 0;margin:0;">
        المبيعات اليومية
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

            @if ($count_days > 0)
                <!-- كروت التجميع -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="alert alert-success text-center">
                            <h5><i class="fas fa-arrow-up"></i> أعلى يوم مبيعات</h5>
                            <h4>{{ number_format($max_day->total_sales, 2) }}</h4>
                            <p class="mb-0">{{ $max_day->pro_date }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-danger text-center">
                            <h5><i class="fas fa-arrow-down"></i> أقل يوم مبيعات</h5>
                            <h4>{{ number_format($min_day->total_sales, 2) }}</h4>
                            <p class="mb-0">{{ $min_day->pro_date }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info text-center">
                            <h5><i class="fas fa-chart-line"></i> متوسط المبيعات اليومية</h5>
                            <h4>{{ number_format($avg_day, 2) }}</h4>
                        </div>
                    </div>
                </div>
            @endif

            <!-- جدول التفاصيل -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>م</th>
                            <th>اليوم</th>
                            <th>إجمالي المبيعات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->pro_date }}</td>
                                <td>{{ number_format($row->total_sales, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">لا توجد بيانات</td>
                            </tr>
                        @endforelse

                        @if ($data->count() > 0)
                            <tr style="font-weight: bold; background: #f0f0f0;">
                                <td colspan="2" class="text-center">الإجمالي الكلي</td>
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
