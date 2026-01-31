@extends('layouts.master')

@section('content')
<style>
    .clients-container {
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
    
    .btn-primary-clean {
        background: #2d3748;
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
    
    .btn-primary-clean:hover {
        background: #4a5568;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    .clients-table-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #eef2f7;
    }
    
    .table-header {
        background: #f8f9fc;
        padding: 25px 30px;
        border-bottom: 1px solid #eef2f7;
    }
    
    .table-title {
        margin: 0;
        font-weight: 700;
        font-size: 1.4rem;
        color: #2d3748;
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
    
    .clean-table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .clean-table tbody tr:hover {
        background-color: #f8f9fc;
    }
    
    .client-link {
        color: #2d3748;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .client-link:hover {
        color: #4299e1;
        text-decoration: none;
    }
    
    .action-buttons-cell {
        display: flex;
        gap: 12px;
    }
    
    .btn-edit-clean {
        background: #e6fffa;
        color: #319795;
        border: 1px solid #b2f5ea;
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
        background: #319795;
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
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #cbd5e0;
    }
</style>

<div class="clients-container container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">
                    <i class="fas fa-users mr-3"></i> قائمة العملاء
                    <span class="badge badge-light ml-2 text-muted" style="font-size: 1rem;">{{ $clients->count() }}</span>
                </h1>
            </div>
            <div class="col-md-6">
                <div class="action-buttons">
                    <a href="{{ route('clients.create') }}" class="btn-primary-clean">
                        <i class="fas fa-plus"></i>
                        عميل جديد
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Clients Table -->
    <div class="clients-table-container">
        <div class="table-responsive">
            <table class="clean-table" id="myTable">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>الاسم</th>
                        <th>تاريخ الميلاد</th>
                        <th>الشكوى</th>
                        <th width="200">عمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('clients.profile', ['id' => $client->id]) }}" class="client-link">{{ $client->name }}</a>
                        </td>
                        <td>{{ $client->dateofbirth }}</td>
                        <td>{{ $client->diseses }}</td>
                        <td>
                            <div class="action-buttons-cell">
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn-edit-clean">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟');">
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
                                <i class="fas fa-user-friends"></i>
                                <h3>لا يوجد عملاء</h3>
                                <p>قم بإضافة عملاء جدد للبدء</p>
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
