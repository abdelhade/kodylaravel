@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card {{ $showEnded ? 'card-warning' : 'card-primary' }}">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('reservations.create') }}" class="btn btn-large bg-sky-300"> إضافة حجز جديد</a>
                    </h3>
                    <h1>الحجوزات{{ $showEnded ? ' المنتهية' : '' }}</h1>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('reservations.index') }}" method="get" id="myForm">
                        <div class="row yyyy">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">من</label>
                                    <input type="date" name="startdate" class="form-control" value="{{ $startDate }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">إلى</label>
                                    <input type="date" name="enddate" class="form-control" value="{{ $endDate }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-lg btn-secondary">بحث</button>
                            </div>
                        </div>
                    </form>

                    <table id="example2" class="table table-bordered table-hover table-responsive text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>تاريخ</th>
                                <th>العميل</th>
                                <th>القابل للتأجير</th>
                                <th>معلومات</th>
                                <th>عمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $index => $reservation)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $reservation->date }}</td>
                                    <td>{{ $reservation->client }}</td>
                                    <td>
                                        @php
                                            $rentable = DB::table('acc_head')->where('id', $reservation->rentable)->first();
                                        @endphp
                                        {{ $rentable->aname ?? 'غير محدد' }}
                                    </td>
                                    <td>{{ $reservation->info ?? 'لا توجد معلومات' }}</td>
                                    <td>
                                        <a href="{{ route('reservations.edit', ['id' => $reservation->id]) }}" class="btn btn-warning btn-sm">تعديل</a>
                                        <a href="{{ route('reservations.destroy', ['id' => $reservation->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
