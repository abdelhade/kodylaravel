@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h2 class="cake cake-zoomOut">إدارة الكروت الذكية</h2>
                    <div class="float-right">
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary">إضافة كارت جديد</a>
                        <a href="{{ route('bookings.scan') }}" class="btn btn-info">استخدام الباركود</a>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('bookings.index') }}" class="btn btn-sm {{ $case === null ? 'btn-primary' : 'btn-secondary' }}">الكل</a>
                        <a href="{{ route('bookings.index', ['case' => 0]) }}" class="btn btn-sm {{ $case == 0 ? 'btn-primary' : 'btn-secondary' }}">نشط</a>
                        <a href="{{ route('bookings.index', ['case' => 1]) }}" class="btn btn-sm {{ $case == 1 ? 'btn-primary' : 'btn-secondary' }}">منتهي</a>
                        <a href="{{ route('bookings.index', ['case' => 2]) }}" class="btn btn-sm {{ $case == 2 ? 'btn-primary' : 'btn-secondary' }}">معلق</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table id="myTable" class="table table-responsive table-hoverable">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>اسم العميل</th>
                                    <th>رقم الكارت</th>
                                    <th>المدفوع</th>
                                    <th>نوع التعاقد</th>
                                    <th>عدد الجلسات</th>
                                    <th>المتبقي</th>
                                    <th>حالة الكارت</th>
                                    <th>من</th>
                                    <th>إلى</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $index => $booking)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $booking->client }}</td>
                                        <td><button class="btn btn-light">{{ $booking->barcode }}</button></td>
                                        <td>{{ $booking->rcost }}</td>
                                        <td>
                                            @php
                                                $bookingType = DB::table('book_tybes')->where('id', $booking->rtybe)->first();
                                            @endphp
                                            {{ $bookingType->name ?? $booking->rtybe }}
                                        </td>
                                        <td>{{ $booking->qty }}</td>
                                        <td>{{ $booking->remain }}</td>
                                        <td>
                                            @if($booking->bcase == 0)
                                                <span class="badge badge-success">نشط</span>
                                            @elseif($booking->bcase == 1)
                                                <span class="badge badge-danger">منتهي</span>
                                            @elseif($booking->bcase == 2)
                                                <span class="badge badge-warning">معلق</span>
                                            @else
                                                {{ $booking->bcase }}
                                            @endif
                                        </td>
                                        <td>{{ $booking->fromdate }}</td>
                                        <td>{{ $booking->todate }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">لا توجد كروت</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
