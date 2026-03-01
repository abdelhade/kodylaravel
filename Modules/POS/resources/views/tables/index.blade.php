@extends('dashboard.layout')

@section('content')

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title float-left">
                        <h2>🍽️ إدارة الطاولات</h2>
                    </div>
                    <button class="btn float-right bg-green-600 text-slate-50" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus"></i> إضافة طاولة
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="table">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>ID</th>
                                    <th>اسم الطاولة</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>آخر تعديل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tables as $index => $table)
                                    <tr>
                                        <td class="p-1">{{ $index + 1 }}</td>
                                        <td class="p-1">{{ $table->id }}</td>
                                        <td class="p-1">{{ $table->tname }}</td>
                                        <td class="p-1">
                                            @if($table->table_case == 0)
                                                <span class="badge badge-success">متاحة</span>
                                            @elseif($table->table_case == 1)
                                                <span class="badge badge-warning">محجوزة</span>
                                            @else
                                                <span class="badge badge-danger">صيانة</span>
                                            @endif
                                        </td>
                                        <td class="p-1">{{ $table->crtime ?? 'N/A' }}</td>
                                        <td class="p-1">{{ $table->mdtime ?? 'N/A' }}</td>
                                        <td class="p-1">
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#editModal{{ $table->id }}">
                                                <span class="fa fa-edit"></span>
                                            </button>
                                            <form action="{{ route('pos.tables.destroy', $table->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الطاولة؟')">
                                                    <span class="fa fa-trash"></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal تعديل -->
                                    <div class="modal fade" id="editModal{{ $table->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('pos.tables.update', $table->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">تعديل الطاولة</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>اسم الطاولة</label>
                                                            <input type="text" name="tname" value="{{ $table->tname }}" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>حالة الطاولة</label>
                                                            <select name="table_case" class="form-control" required>
                                                                <option value="0" {{ $table->table_case == 0 ? 'selected' : '' }}>متاحة</option>
                                                                <option value="1" {{ $table->table_case == 1 ? 'selected' : '' }}>محجوزة</option>
                                                                <option value="2" {{ $table->table_case == 2 ? 'selected' : '' }}>صيانة</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">لا توجد طاولات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<!-- Modal إضافة -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pos.tables.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">إضافة طاولة جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم الطاولة</label>
                        <input type="text" name="tname" class="form-control" required placeholder="مثال: طاولة 1">
                    </div>
                    <div class="form-group">
                        <label>حالة الطاولة</label>
                        <select name="table_case" class="form-control" required>
                            <option value="0">متاحة</option>
                            <option value="1">محجوزة</option>
                            <option value="2">صيانة</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success">إضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
