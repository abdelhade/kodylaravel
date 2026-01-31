@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post">
                    @csrf
                    <div class="card-header">
                        <h1>المبيعات بالساعات</h1>
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
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="alert alert-info">
                                <b>متوسط الساعة:</b><br>
                                {{ number_format($avg, 2) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-warning">
                                <b>الإجمالي الكلي:</b><br>
                                {{ number_format($grand_total, 2) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-success">
                                <b>أعلى ساعة:</b><br>
                                {{ sprintf("%02d:00", $max_hour) }} 
                                ({{ number_format($max_val, 2) }})
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="alert alert-danger">
                                <b>أقل ساعة:</b><br>
                                {{ sprintf("%02d:00", $min_hour) }} 
                                ({{ number_format($min_val, 2) }})
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
                                @for($h = 0; $h < 24; $h++)
                                    @php
                                        $val = $hours[$h];
                                        if ($val > $avg) {
                                            $mark = "✅ فوق المتوسط";
                                            $style = "background: #d4edda;";
                                        } elseif ($val < $avg && $val > 0) {
                                            $mark = "❌ تحت المتوسط";
                                            $style = "background: #f8d7da;";
                                        } else {
                                            $mark = "⚖️ يساوي المتوسط";
                                            $style = "background: #fff3cd;";
                                        }
                                    @endphp
                                    <tr style="{{ $style }}">
                                        <td>{{ sprintf("%02d:00", $h) }}</td>
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
    </section>
</div>
@endsection
