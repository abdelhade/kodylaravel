@extends('dashboard.layout')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $lang['lang_departlist'] ?? 'قائمة الأقسام' }}</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('departments.create') }}" class="btn btn-large btn-primary">
                                {{ $lang['lang_add_new'] ?? 'إضافة جديد' }}
                            </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
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
                                @forelse($departments as $index => $department)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th><a href="#">{{ $department->name }}</a></th>
                                        <th>{{ $department->info ?? '' }}</th>
                                        <th>
                                            <a class="btn btn-sm btn-success" href="{{ route('departments.edit', ['id' => $department->id]) }}">
                                              <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $department->id }}">
                                              <i class="fa fa-trash"></i>
                                            </button>
                                        </th>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $department->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تحذير</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد بالتأكيد حذف {{ $department->name }}؟</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">إلغاء</button>
                                                    <form action="{{ route('departments.destroy', ['id' => $department->id]) }}" method="POST" class="d-inline">
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
                                        <td colspan="4" class="text-center">لا توجد أقسام</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
