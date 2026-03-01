@extends('dashboard.layout')

@section('content')
<style>
    .table-responsive {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      padding: 1rem;
      overflow-x: auto;
    }
    .table {
      margin-bottom: 0;
      min-width: 800px;
    }
    .table th {
      background-color: #f8f9fa;
      white-space: nowrap;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">👥 إدارة العملاء المحتملون</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> إضافة عميل محتمل
            </button>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-hover text-center" id="myTable">
                <thead class="table-light">
                    <tr>
                        <th>م</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الهاتف</th>
                        <th>الشركة</th>
                        <th>المصدر</th>
                        <th>الحالة</th>
                        <th>تاريخ الإضافة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $index => $lead)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>{{ $lead->company }}</td>
                        <td>{{ $lead->source_name }}</td>
                        <td>{{ $lead->status_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('Y-m-d') }}</td>
                        <td class="text-nowrap">
                            <button class="btn btn-sm btn-outline-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $lead->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="{{ route('leads.destroy') }}?id={{ $lead->id }}" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('هل تريد حذف {{ $lead->name }}؟')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal تعديل -->
                    <div class="modal fade" id="editModal{{ $lead->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('leads.update') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $lead->id }}">
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل عميل محتمل</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">الاسم <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ $lead->name }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">البريد الإلكتروني</label>
                                                <input type="email" name="email" value="{{ $lead->email }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">الهاتف</label>
                                                <input type="text" name="phone" value="{{ $lead->phone }}" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">الشركة</label>
                                                <input type="text" name="company" value="{{ $lead->company }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">المصدر <span class="text-danger">*</span></label>
                                                <select name="source_id" class="form-select" required>
                                                    @foreach($sources as $source)
                                                    <option value="{{ $source->id }}" {{ $lead->source_id == $source->id ? 'selected' : '' }}>
                                                        {{ $source->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">الحالة <span class="text-danger">*</span></label>
                                                <select name="status_id" class="form-select" required>
                                                    @foreach($statuses as $status)
                                                    <option value="{{ $status->id }}" {{ $lead->status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ملاحظات</label>
                                            <textarea name="notes" class="form-control" rows="3">{{ $lead->notes }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal إضافة -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('leads.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">إضافة عميل محتمل جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاسم <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الهاتف</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الشركة</label>
                            <input type="text" name="company" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المصدر <span class="text-danger">*</span></label>
                            <select name="source_id" class="form-select" required>
                                <option value="">اختر المصدر</option>
                                @foreach($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الحالة <span class="text-danger">*</span></label>
                            <select name="status_id" class="form-select" required>
                                <option value="">اختر الحالة</option>
                                @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">إضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
