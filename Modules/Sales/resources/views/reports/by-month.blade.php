@extends('dashboard.layout')

@section('content')
<div class="container-fluid p-2">
    <h4 class="font-thin text-md text-white text-center"
        style="font-size:2em;padding:15px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius: 10px 10px 0 0;margin:0;">
        المبيعات الشهرية
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

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info text-center">
                        <h5><i class="fas fa-calculator"></i> الإجمالي الكلي</h5>
                        <h3>{{ number_format($grand_total, 2) }}</h3>
                    </div>
                </div>
            </div>

            <!-- جدول المبيعات -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>م</th>
                            <th>الشهر</th>
                            <th>إجمالي المبيعات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($months as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->sales_month }}</td>
                                <td>{{ number_format($row->total_sales, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">لا توجد بيانات</td>
                            </tr>
                        @endforelse

                        @if ($months->count() > 0)
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
