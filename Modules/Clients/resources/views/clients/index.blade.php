@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="h3">قائمة العملاء {{ $clientCount }}</div>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('clients.create') }}">
                                <div class="btn btn-primary">جديد</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الميلاد</th>
                                    <th>الشكوي</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $index => $client)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th>
                                            <a class="btn btn-block btn-secondary" href="{{ route('clients.profile', ['id' => $client->id]) }}">
                                                {{ $client->name }}
                                            </a>
                                        </th>
                                        <th>{{ $client->dateofbirth }}</th>
                                        <th>{{ $client->diseses }}</th>
                                        <th>
                                            <a href="{{ route('clients.edit', ['id' => $client->id]) }}" class="btn btn-warning btn-sm">تعديل</a>
                                            <a href="{{ route('clients.destroy', ['id' => $client->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                                        </th>
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
