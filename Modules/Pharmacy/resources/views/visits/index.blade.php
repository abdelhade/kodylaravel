@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الزيارات</h1>
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
                            <a href="{{ route('visits.create') }}" class="btn btn-large btn-primary">
                                إضافة زيارة
                            </a>
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>اسم المريض</th>
                                    <th>السن</th>
                                    <th>الوظيفة</th>
                                    <th>تاريخ الزيارة</th>
                                    <th>الشكوى</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($visits as $index => $visit)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $visit->client_name }}</td>
                                        <td>{{ $visit->client_age }}</td>
                                        <td>{{ $visit->client_degree }}</td>
                                        <td>{{ \Carbon\Carbon::parse($visit->created_at)->format('Y-m-d') }}</td>
                                        <td>{{ Str::limit($visit->complaint ?? '-', 50) }}</td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="{{ route('visits.edit', ['id' => $visit->id]) }}">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $visit->id }}">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $visit->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تحذير</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد بالتأكيد حذف هذه الزيارة؟</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">إلغاء</button>
                                                    <form action="{{ route('visits.destroy', ['id' => $visit->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-light">حذف</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">لا توجد زيارات</td>
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
