@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $lang['lang_employeeslist'] ?? 'قائمة الموظفين' }}</h1>
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
                            <a href="{{ route('employees.create') }}" class="btn btn-large btn-primary">
                                {{ $lang['lang_add_new'] ?? 'إضافة جديد' }}
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

                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>id</th>
                                    <th>{{ $lang['lang_publicname'] ?? 'الاسم' }}</th>
                                    <th>{{ $lang['lang_publicjob'] ?? 'الوظيفة' }}</th>
                                    <th>التليفون</th>
                                    <th>KBI</th>
                                    <th>القسم</th>
                                    <th>الشيفت</th>
                                    <th>الراتب</th>
                                    <th>{{ $lang['lang_publicinfo'] ?? 'معلومات' }}</th>
                                    <th>{{ $lang['lang_publicoperations'] ?? 'عمليات' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $index => $employee)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $employee->id }}</td>
                                        <td>
                                            <a class="btn btn-outline-dark btn-edged font-thin" href="{{ route('employees.profile', ['id' => $employee->id]) }}">
                                                {{ $employee->name }}
                                            </a>
                                        </td>
                                        <td>{{ $employee->job_name }}</td>
                                        <td>{{ $employee->number }}</td>
                                        <td>{{ $employee->kbi_sum }}</td>
                                        <td>{{ $employee->department_name }}</td>
                                        <td>{{ $employee->shift_name }}</td>
                                        <td>{{ $employee->salary }}</td>
                                        <td>{{ $employee->info }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{ route('employees.edit') }}?id={{ $employee->id }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('employees.destroy') }}?id={{ $employee->id }}" method="post" style="display: inline-block;" onsubmit="return confirm('هل تريد بالتأكيد حذف {{ $employee->name }}؟')">
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
