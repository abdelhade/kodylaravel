@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>قائمة الفرص</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route('opportunities.create') }}" class="btn btn-large btn-primary">
                                إضافة جديد
                            </a>
                        </h3>
                    </div>
                    <div class="card-body table-responsive">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>العنوان</th>
                                    <th>العميل المحتمل</th>
                                    <th>المرحلة</th>
                                    <th>المبلغ</th>
                                    <th>احتمالية النجاح</th>
                                    <th>تاريخ الإغلاق المتوقع</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($opportunities as $index => $opportunity)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $opportunity->title }}</td>
                                        <td>{{ $opportunity->lead_name }}</td>
                                        <td>{{ $opportunity->stage_name }}</td>
                                        <td>{{ number_format($opportunity->amount, 2) }}</td>
                                        <td>{{ $opportunity->probability }}%</td>
                                        <td>{{ $opportunity->expected_close_date }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{ route('opportunities.edit') }}?id={{ $opportunity->id }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('opportunities.destroy') }}?id={{ $opportunity->id }}" method="post" style="display: inline-block;" onsubmit="return confirm('هل تريد بالتأكيد حذف {{ $opportunity->title }}؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
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

@endsection
