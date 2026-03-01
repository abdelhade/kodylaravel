@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>قائمة جهات الاتصال</h1>
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
                            <a href="{{ route('contacts.create') }}" class="btn btn-large btn-primary">
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
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>الموبايل</th>
                                    <th>الشركة</th>
                                    <th>المنصب</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $index => $contact)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->phone }}</td>
                                        <td>{{ $contact->mobile }}</td>
                                        <td>{{ $contact->company }}</td>
                                        <td>{{ $contact->position }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{ route('contacts.edit') }}?id={{ $contact->id }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('contacts.destroy') }}?id={{ $contact->id }}" method="post" style="display: inline-block;" onsubmit="return confirm('هل تريد بالتأكيد حذف {{ $contact->name }}؟')">
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
