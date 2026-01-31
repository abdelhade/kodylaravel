@extends('layouts.master')

@section('content')
<style>
    .suppliers-container {
        padding: 30px;
        background-color: #f8f9fc;
        min-height: 100vh;
    }
    
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        border: 1px solid #eef2f7;
    }
    
    .page-title {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 0;
        font-size: 2rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
    
    .btn-indigo-clean {
        background: #4c51bf;
        border: none;
        border-radius: 10px;
        padding: 14px 28px;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    
    .btn-indigo-clean:hover {
        background: #434190;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    .suppliers-table-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #eef2f7;
    }
    
    .clean-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1.1rem;
    }
    
    .clean-table thead {
        background-color: #f8f9fc;
    }
    
    .clean-table th {
        padding: 20px 25px;
        text-align: right;
        font-weight: 700;
        color: #2d3748;
        border-bottom: 2px solid #e2e8f0;
        font-size: 1.1rem;
    }
    
    .clean-table td {
        padding: 20px 25px;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
        color: #4a5568;
        font-size: 1.05rem;
    }
    
    .clean-table tbody tr:hover {
        background-color: #f8f9fc;
    }
    
    .action-buttons-cell {
        display: flex;
        gap: 12px;
    }
    
    .btn-edit-clean {
        background: #ebf4ff;
        color: #3182ce;
        border: 1px solid #bee3f8;
        border-radius: 8px;
        padding: 8px 16px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .btn-edit-clean:hover {
        background: #3182ce;
        color: white;
        text-decoration: none;
    }
    
    .btn-delete-clean {
        background: #fff5f5;
        color: #e53e3e;
        border: 1px solid #fed7d7;
        border-radius: 8px;
        padding: 8px 16px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .btn-delete-clean:hover {
        background: #e53e3e;
        color: white;
        text-decoration: none;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }
</style>

<div class="suppliers-container container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">
                    <i class="fas fa-truck mr-3"></i> قائمة الموردين
                    <span class="badge badge-light ml-2 text-muted" style="font-size: 1rem;">{{ $suppliers->count() }}</span>
                </h1>
            </div>
            <div class="col-md-6">
                <div class="action-buttons">
                    <a href="{{ route('suppliers.create') }}" class="btn-indigo-clean">
                        <i class="fas fa-plus"></i>
                        مورد جديد
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Suppliers Table -->
    <div class="suppliers-table-container mt-4">
        <div class="table-responsive">
            <table class="clean-table">
                <thead>
                    <tr>
                        <th width="80">الكود</th>
                        <th>اسم المورد</th>
                        <th>التليفون</th>
                        <th>العنوان</th>
                        <th width="200">عمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td><span class="badge badge-info">{{ $supplier->code }}</span></td>
                        <td><strong>{{ $supplier->aname }}</strong></td>
                        <td>{{ $supplier->phone ?? '-' }}</td>
                        <td>{{ $supplier->address ?? '-' }}</td>
                        <td>
                            <div class="action-buttons-cell">
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn-edit-clean">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المورد؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-clean">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-truck-loading fa-3x mb-3 text-muted"></i>
                                <h3>لا يوجد موردين</h3>
                                <p>قم بإضافة موردين جدد للبدء</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
