@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('prescriptions.create') }}" class="btn btn-large btn-primary">إضافة روشتة</a>
                    </h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>اسم المريض</th>
                                    <th>الدواء</th>
                                    <th>الأشعة</th>
                                    <th>التحاليل</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prescriptions as $index => $prescription)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $prescription->client_name }}</td>
                                        <td>{{ $prescription->first_drug }}</td>
                                        <td>--</td>
                                        <td>{{ $prescription->analayses ?? '--' }}</td>
                                        <td>
                                            <a href="{{ route('prescriptions.show', ['id' => $prescription->id]) }}" class="btn btn-info btn-sm">عرض</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">لا توجد روشتات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>م</th>
                                    <th>اسم المريض</th>
                                    <th>الدواء</th>
                                    <th>الأشعة</th>
                                    <th>التحاليل</th>
                                    <th>عمليات</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
