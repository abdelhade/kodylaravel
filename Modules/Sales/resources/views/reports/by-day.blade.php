@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post">
                    @csrf
                    <div class="card-header">
                        <h1>المبيعات أيام</h1>
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

                @if($count_days > 0)
                <!-- كروت التجميع -->
                <div class="row p-3">
                    <div class="col-md-4">
                        <div class="alert alert-success text-center">
                            <h5>أعلى يوم مبيعات</h5>
                            <p>{{ $max_day->pro_date }} : {{ number_format($max_day->total_sales, 2) }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-danger text-center">
                            <h5>أقل يوم مبيعات</h5>
                            <p>{{ $min_day->pro_date }} : {{ number_format($min_day->total_sales, 2) }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info text-center">
                            <h5>متوسط المبيعات اليومية</h5>
                            <p>{{ number_format($avg_day, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- جدول التفاصيل -->
                <div class="card-body">
                    <div class="table">
                        <table class="table table-bordered">
                            <thead>
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

                                @if($data->count() > 0)
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
    </section>
</div>
@endsection
