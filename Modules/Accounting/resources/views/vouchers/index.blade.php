@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('vouchers.index') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <h1>السندات</h1>
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('vouchers.create', ['t' => 'recive']) }}" class="btn btn-primary">سند قبض</a>
                                <a href="{{ route('vouchers.create', ['t' => 'payment']) }}" class="btn btn-primary">سند دفع</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-2">
                                <label>النوع</label>
                                <select name="tybe" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="1" {{ request('tybe') == '1' ? 'selected' : '' }}>سند قبض</option>
                                    <option value="2" {{ request('tybe') == '2' ? 'selected' : '' }}>سند دفع</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label>من تاريخ</label>
                                <input type="date" name="strt" class="form-control" value="{{ request('strt') }}">
                            </div>
                            <div class="col-lg-2">
                                <label>إلى تاريخ</label>
                                <input type="date" name="end" class="form-control" value="{{ request('end') }}">
                            </div>
                            <div class="col-lg-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الرقم</th>
                                    <th>التاريخ</th>
                                    <th>النوع</th>
                                    <th>القيمة</th>
                                    <th>من حساب</th>
                                    <th>إلى حساب</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->id }}</td>
                                        <td>{{ $voucher->pro_id }}</td>
                                        <td>{{ $voucher->pro_date }}</td>
                                        <td>
                                            @if($voucher->pro_tybe == 1)
                                                <span class="badge bg-success">سند قبض</span>
                                            @else
                                                <span class="badge bg-danger">سند دفع</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($voucher->pro_value, 2) }}</td>
                                        <td>{{ $voucher->acc1_name }}</td>
                                        <td>{{ $voucher->acc2_name }}</td>
                                        <td>
                                            <a href="{{ route('vouchers.edit', ['edit' => $voucher->id]) }}" class="btn btn-warning btn-sm">تعديل</a>
                                            <a href="{{ route('vouchers.destroy', ['id' => $voucher->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
