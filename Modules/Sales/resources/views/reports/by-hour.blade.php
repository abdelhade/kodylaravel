@extends('dashboard.layout')

@section('content')
<div class="container-fluid p-2">
    <h4 class="font-thin text-md text-white text-center"
        style="font-size:2em;padding:15px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius: 10px 10px 0 0;margin:0;">
        المبيعات بالساعات
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
                <div class="col-md-3">
                    <div class="alert alert-info text-center">
                        <h5><i class="fas fa-chart-line"></i> متوسط الساعة</h5>
                        <h4>{{ number_format($avg, 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="alert alert-warning text-center">
                        <h5><i class="fas fa-calculator"></i> الإجمالي الكلي</h5>
                        <h4>{{ number_format($grand_total, 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="alert alert-success text-center">
                        <h5><i class="fas fa-arrow-up"></i> أعلى ساعة</h5>
                        <h4>{{ sprintf('%02d:00', $max_hour) }}</h4>
                        <p class="mb-0">({{ number_format($max_val, 2) }})</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="alert alert-danger text-center">
                        <h5><i class="fas fa-arrow-down"></i> أقل ساعة</h5>
                        <h4>{{ sprintf('%02d:00', $min_hour) }}</h4>
                        <p class="mb-0">({{ number_format($min_val, 2) }})</p>
                    </div>
                </div>
            </div>

                <div class="table">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>الساعة</th>
                                <th>إجمالي المبيعات</th>
                                <th>التصنيف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($h = 0; $h < 24; $h++)
                                @php
                                    $val = $hours[$h];
                                    if ($val > $avg) {
                                        $mark = '✅ فوق المتوسط';
                                        $style = 'background: #d4edda;';
                                    } elseif ($val < $avg && $val > 0) {
                                        $mark = '❌ تحت المتوسط';
                                        $style = 'background: #f8d7da;';
                                    } else {
                                        $mark = '⚖️ يساوي المتوسط';
                                        $style = 'background: #fff3cd;';
                                    }
                                @endphp
                                <tr style="{{ $style }}">
                                    <td>{{ sprintf('%02d:00', $h) }}</td>
                                    <td>{{ number_format($val, 2) }}</td>
                                    <td>{{ $mark }}</td>
                                </tr>
                            @endfor

                            <tr style="font-weight: bold; background: #f0f0f0;">
                                <td class="text-center">الإجمالي الكلي</td>
                                <td colspan="2">{{ number_format($grand_total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection