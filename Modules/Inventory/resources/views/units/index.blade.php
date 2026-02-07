@extends('dashboard.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 style="font-size: 20px; font-weight: bolder;">الوحدات</h3>
                <small class="text-muted">تعريف وحدات القياس المستخدمة مع الأصناف</small>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 style="font-size: 20px; font-weight: bolder;">إدارة الوحدات</h5>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addUnitModal">
                    <i class="fa fa-plus"></i> إضافة وحدة
                </button>
            </div>
            <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif



                    <div class="table-responsive mt-4" id="horsTable">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الوحدة</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($units as $index => $unit)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $unit->uname }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success" 
                                                    data-toggle="modal" data-target="#editModal{{ $unit->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ route('units.destroy', ['id' => $unit->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه الوحدة؟');">
                                                @csrf
                                                @method('DELETE')                                                    
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $unit->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تعديل الوحدة</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('units.update', ['id' => $unit->id]) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="uname{{ $unit->id }}">اسم الوحدة</label>
                                                            <input type="text" class="form-control" id="uname{{ $unit->id }}" 
                                                                   name="uname" value="{{ $unit->uname }}" required>
                                                            @error('uname')
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
                                        <td colspan="3" class="text-center">لا توجد وحدات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</section>

    <!-- Add Unit Modal -->
    <div class="modal fade" id="addUnitModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة وحدة جديدة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('units.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="uname">اسم الوحدة</label>
                            <input type="text" class="form-control" id="uname" 
                                   name="uname" placeholder="أدخل اسم الوحدة" value="{{ old('uname') }}" required pattern=".{3,}" title="يجب أن يكون الاسم 3 أحرف على الأقل">
                            @error('uname')
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
