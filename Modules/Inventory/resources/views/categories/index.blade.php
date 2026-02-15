@extends('dashboard.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 style="font-size: 20px; font-weight: bolder;">التصنيفات</h3>
                <small class="text-muted">تصنيفات إضافية للأصناف لمرونة أكبر في التقارير</small>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 style="font-size: 20px; font-weight: bolder;">إدارة التصنيفات</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                    <i class="fa fa-plus"></i> إضافة تصنيف
                </button>
            </div>
            <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="mb-3">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addCategoryModal">
                            <i class="fa fa-plus"></i> إضافة تصنيف جديد
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
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
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ $category->gname }}
                                        </td>
                                        <td>
                                                <button type="button" class="btn btn-sm btn-success" 
                                                        data-toggle="modal" data-target="#editModal{{ $category->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا التصنيف؟');">
                                                    @csrf
                                                    @method('DELETE')                                                    
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $category->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تعديل التصنيف</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('categories.update', ['id' => $category->id]) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="gname{{ $category->id }}">اسم التصنيف</label>
                                                            <input type="text" class="form-control" id="gname{{ $category->id }}" 
                                                                   name="gname" value="{{ $category->gname }}" required>
                                                            @error('gname')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                                                    </div>
                                                </form>
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
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة تصنيف جديد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('categories.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="newCategoryName">اسم التصنيف</label>
                            <input type="text" class="form-control" id="newCategoryName" 
                                   name="gname" placeholder="أدخل تصنيف جديد" value="{{ old('gname') }}" required>
                            @error('gname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-info">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
