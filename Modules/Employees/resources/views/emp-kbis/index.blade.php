@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left">معدلات التقييم بالنسبة للموظفين</h2>
                    <div>
                        <a class="btn bg-lime-400 float-right" href="{{ route('emp-kbis.create') }}">+</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table">
                        <table id="mytable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>اسم الموظف</th>
                                    <th>المعدلات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $index => $employee)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('employees.profile', ['id' => $employee->emp_id]) }}">
                                                {{ $employee->emp_name }}
                                            </a>
                                            <a href="{{ route('emp-kbis.create', ['c' => $employee->emp_name, 'i' => $employee->emp_id, 'q' => 'f898sd897fg98']) }}">
                                                <i class="fa fa-copy btn btn-sm bg-slate-200 float-right"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @foreach($employee->knames_array as $kname)
                                                <span class="badge badge-primary">{{ $kname }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">لا توجد بيانات</td>
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
