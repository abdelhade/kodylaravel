@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h2>التصنيفات</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="col-md-4 border rounded m-0 p-3 mb-3">
                        <form action="{{ route('categories.store') }}" method="post">
                            @csrf
                            <input type="text" name="gname" class="form-control" 
                                   placeholder="أدخل تصنيف جديد" value="{{ old('gname') }}" required>
                            @error('gname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="btn btn-info btn-block mt-2">حفظ</button>
                        </form>
                    </div>

                    <div class="table-responsive" id="">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم التصنيف</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $category)
                                    <tr>
                                        <form action="{{ route('categories.update', ['id' => $category->id]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <th>{{ $index + 1 }}</th>
                                            <th>
                                                <input class="form-control" type="text" value="{{ $category->gname }}" name="gname" required>
                                            </th>
                                            <th>
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                                <button type="button" class="btn bg-red-600 text-red-100 btn-sm" 
                                                        data-toggle="modal" data-target="#deleteModal{{ $category->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </th>
                                        </form>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $category->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تحذير</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل تريد بالتأكيد حذف {{ $category->gname }}؟</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">إلغاء</button>
                                                    <form action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="POST" class="d-inline">
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
                                        <td colspan="3" class="text-center">لا توجد تصنيفات</td>
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
