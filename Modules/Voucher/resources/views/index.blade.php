@extends('dashboard.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- إحصائيات سريعة -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $vouchers->where('pro_tybe', 1)->count() }}</h3>
                            <p>سندات القبض</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <a href="{{ route('voucher.index', ['t' => 'recive']) }}" class="small-box-footer">
                            عرض التفاصيل <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $vouchers->where('pro_tybe', 2)->count() }}</h3>
                            <p>سندات الدفع</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                        <a href="{{ route('voucher.index', ['t' => 'payment']) }}" class="small-box-footer">
                            عرض التفاصيل <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($vouchers->sum('pro_value'), 2) }}</h3>
                            <p>إجمالي المبالغ</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            &nbsp;
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- جدول السندات -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> قائمة السندات
                    </h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <a href="{{ route('voucher.create', ['t' => 'recive']) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> سند قبض
                            </a>
                            <a href="{{ route('voucher.create', ['t' => 'payment']) }}" class="btn btn-danger btn-sm">
                                <i class="fas fa-plus"></i> سند دفع
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="icon fas fa-check"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="icon fas fa-ban"></i> {{ session('error') }}
                        </div>
                    @endif
                    
                    <!-- فورم البحث -->
                    <form action="{{ route('voucher.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>نوع السند</label>
                                    <select class="form-control" name="tybe">
                                        <option value="">كل السندات</option>
                                        <option value="1" {{ request('tybe') == '1' ? 'selected' : '' }}>سندات قبض</option>
                                        <option value="2" {{ request('tybe') == '2' ? 'selected' : '' }}>سندات دفع</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>من تاريخ</label>
                                    <input type="date" class="form-control" name="strt" value="{{ request('strt') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>إلى تاريخ</label>
                                    <input type="date" class="form-control" name="end" value="{{ request('end') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>التاريخ</th>
                                    <th>النوع</th>
                                    <th>رقم السند</th>
                                    <th>المبلغ</th>
                                    <th>الحساب الأساسي</th>
                                    <th>الحساب المقابل</th>
                                    <th>البيان</th>
                                    <th style="width: 120px;">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vouchers as $index => $voucher)
                                <tr>
                                    <td>{{ $vouchers->firstItem() + $index }}</td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-muted"></i>
                                        {{ $voucher->pro_date }}
                                    </td>
                                    <td>
                                        @if($voucher->pro_tybe == 1)
                                            <span class="badge badge-success">
                                                <i class="fas fa-arrow-down"></i> قبض
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-arrow-up"></i> دفع
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="text-primary">{{ $voucher->pro_id }}</strong>
                                    </td>
                                    <td>
                                        <strong class="text-{{ $voucher->pro_tybe == 1 ? 'success' : 'danger' }}">
                                            {{ number_format($voucher->pro_value, 2) }}
                                        </strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $voucher->acc1_name }}</small>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $voucher->acc2_name }}</small>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($voucher->info, 30) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('voucher.edit', ['id' => $voucher->id, 't' => $voucher->pro_tybe == 1 ? 'recive' : 'payment']) }}" 
                                               class="btn btn-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal{{ $voucher->id }}"
                                                    title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Modal حذف -->
                                <div class="modal fade" id="deleteModal{{ $voucher->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-exclamation-triangle"></i> تأكيد الحذف
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-0">
                                                    هل أنت متأكد من حذف السند رقم <strong>{{ $voucher->pro_id }}</strong>؟
                                                </p>
                                                <p class="text-danger mb-0">
                                                    <small><i class="fas fa-info-circle"></i> سيتم حذف القيود المحاسبية المرتبطة بهذا السند</small>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times"></i> إلغاء
                                                </button>
                                                <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>لا توجد سندات</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $vouchers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
