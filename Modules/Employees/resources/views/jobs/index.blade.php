@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $lang['lang_jobslist'] ?? 'قائمة الوظائف' }}</h1>
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
                            <a href="{{ route('jobs.create') }}" class="btn btn-large btn-primary">
                                {{ $lang['lang_add_new'] ?? 'إضافة جديد' }}
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
                                    <th>{{ $lang['lang_publicname'] ?? 'الاسم' }}</th>
                                    <th>{{ $lang['lang_publicinfo'] ?? 'معلومات' }}</th>
                                    <th>{{ $lang['lang_publicoperations'] ?? 'عمليات' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $index => $job)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th><a href="#">{{ $job->name }}</a></th>
                                        <th>{{ $job->info ?? '' }}</th>
                                        <th>
                                            <a class="btn btn-warning" href="{{ route('jobs.edit', ['id' => $job->id]) }}">
                                                {{ $lang['lang_edit'] ?? 'تعديل' }}
                                            </a>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $job->id }}">
                                                حذف
                                            </button>
                                        </th>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $job->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تحذير</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد بالتأكيد حذف {{ $job->name }}؟</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">إلغاء</button>
                                                    <form action="{{ route('jobs.destroy', ['id' => $job->id]) }}" method="POST" class="d-inline">
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
                                        <td colspan="4" class="text-center">لا توجد وظائف</td>
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
