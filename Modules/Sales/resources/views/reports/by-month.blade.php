@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post">
                    @csrf
                    <div class="card-header">
                        <h1>المبيعات شهرياً</h1>
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
                    <div class="table">
                        <table class="table table-bordered">
                            <thead>
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

                                @if($months->count() > 0)
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
