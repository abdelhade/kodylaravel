@extends('layouts.master')

@section('title', 'إدارة الطاولات')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0"><i class="fas fa-table me-2"></i>إدارة الطاولات</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('pos.tables.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus me-1"></i>إضافة طاولة
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($tables->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>اسم الطاولة</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>آخر تعديل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tables as $table)
                                <tr>
                                    <td>{{ $table->id }}</td>
                                    <td>{{ $table->tname }}</td>
                                    <td>
                                        <span class="badge bg-{{ $table->table_case == 0 ? 'success' : ($table->table_case == 1 ? 'warning' : 'danger') }}">
                                            {{ $table->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>{{ $table->created_at ?? 'N/A' }}</td>
                                    <td>{{ $table->updated_at ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('pos.tables.edit', $table) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pos.tables.destroy', $table) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>لا توجد طاولات متاحة
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
