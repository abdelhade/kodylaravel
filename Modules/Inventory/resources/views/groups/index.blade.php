@extends('dashboard.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3  style="font-size: 20px; font-weight: bolder;">مجموعات الأصناف</h3>
                <small class="text-muted">تنظيم الأصناف في مجموعات رئيسية / فرعية</small>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 style="font-size: 20px; font-weight: bolder;">إدارة المجموعات</h5>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addGroupModal">
                    <i class="fa fa-plus"></i> إضافة مجموعة
                </button>
            </div>
            <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المجموعة</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groups as $index => $group)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ $group->gname }}
                                        </td>
                                        <td>
                                                <button type="button" class="btn btn-sm btn-success" 
                                                        data-toggle="modal" data-target="#editModal{{ $group->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form action="{{ route('groups.destroy', ['id' => $group->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه المجموعة؟');">
                                                    @csrf
                                                    @method('DELETE')                                                    
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $group->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تعديل المجموعة</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('groups.update', ['id' => $group->id]) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="gname{{ $group->id }}">اسم المجموعة</label>
                                                            <input type="text" class="form-control" id="gname{{ $group->id }}" 
                                                                   name="gname" value="{{ $group->gname }}" required>
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
                                        <td colspan="3" class="text-center">لا توجد مجموعات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</section>
    <!-- Add Group Modal -->
    <div class="modal fade" id="addGroupModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة مجموعة جديدة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('groups.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="gname">اسم المجموعة</label>
                            <input type="text" class="form-control" id="gname" 
                                   name="gname" placeholder="أدخل اسم المجموعة" value="{{ old('gname') }}" required>
                            @error('gname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
