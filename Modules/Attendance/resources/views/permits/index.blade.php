@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="">ادارة الاذونات</h3>
                </div>
                <div class="card-body">
                    @if(count($permits) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الموظف</th>
                                        <th>نوع الإذن</th>
                                        <th>من تاريخ</th>
                                        <th>إلى تاريخ</th>
                                        <th>السبب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permits as $permit)
                                        <tr>
                                            <td>{{ $permit->id }}</td>
                                            <td>{{ $permit->employee_id ?? 'N/A' }}</td>
                                            <td>{{ $permit->type ?? 'N/A' }}</td>
                                            <td>{{ $permit->from_date ?? 'N/A' }}</td>
                                            <td>{{ $permit->to_date ?? 'N/A' }}</td>
                                            <td>{{ $permit->reason ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('permits.edit', ['id' => $permit->id]) }}" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i> تعديل
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>لا توجد أذونات مسجلة حالياً.</p>
                            <a href="{{ route('permits.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> إضافة إذن جديد
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
