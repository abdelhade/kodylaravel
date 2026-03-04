@extends('dashboard.layout')

@section('content')
    <div class="container-fluid p-2">
        <h4 class="font-thin text-md text-white text-center"
            style="font-size:2em;padding:15px;background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);border-radius: 10px 10px 0 0;margin:0;">
            فواتير المشتريات
        </h4>

        <div class="card" style="border-radius: 0 0 10px 10px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="card-body p-3">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- فلتر البحث -->
                <form method="GET" action="{{ route('purchases.index') }}" class="mb-3">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <input type="date" name="from_date" class="form-control"
                                value="{{ request('from_date', date('Y-m-01')) }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control"
                                value="{{ request('to_date', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-2">
                            <select name="invoice_type" class="form-control" style="border: 2px solid #26a69a;">
                                <option value="all" {{ request('invoice_type', 'all') == 'all' ? 'selected' : '' }}>الكل
                                </option>
                                <option value="purchase" {{ request('invoice_type') == 'purchase' ? 'selected' : '' }}>
                                    فاتورة مشتريات</option>
                                <option value="order" {{ request('invoice_type') == 'order' ? 'selected' : '' }}>أمر شراء
                                </option>
                                <option value="return" {{ request('invoice_type') == 'return' ? 'selected' : '' }}>مردود
                                    مشتريات</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block" style="background: #4169E1;">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                        <div class="col-md-4 text-left">
                            <a href="{{ route('purchases.invoice') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> فاتورة مشتريات 
                            </a>
                            <a href="{{ route('purchases.return') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-undo"></i> مردود مشتريات
                            </a>
                            <a href="{{ route('purchases.order') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-file-alt"></i> أمر شراء
                            </a>
                            <button onclick="window.print()" class="btn btn-secondary btn-sm">
                                <i class="fas fa-print"></i> طباعة
                            </button>
                        </div>

                    </div>
                </form>

                <!-- رسالة الفلتر النشط -->
                @if (request('invoice_type') && request('invoice_type') != 'all')
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-filter"></i>
                        <strong>فلتر نشط:</strong>
                        عرض
                        @if (request('invoice_type') == 'purchase')
                            <strong>فواتير المشتريات</strong> فقط
                        @elseif(request('invoice_type') == 'order')
                            <strong>أوامر الشراء</strong> فقط
                        @elseif(request('invoice_type') == 'return')
                            <strong>مرتجعات المشتريات</strong> فقط
                        @endif
                        <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-light mr-2">
                            <i class="fas fa-times"></i> إلغاء الفلتر
                        </a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <!-- الإحصائيات -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-file-invoice"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">عدد
                                    @if (request('invoice_type') == 'purchase')
                                        الفواتير
                                    @elseif(request('invoice_type') == 'order')
                                        الأوامر
                                    @elseif(request('invoice_type') == 'return')
                                        المرتجعات
                                    @else
                                        العمليات
                                    @endif
                                </span>
                                <span class="info-box-number">{{ $invoices->total() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">إجمالي المشتريات</span>
                                <span class="info-box-number">{{ number_format($invoices->sum('fat_total'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">إجمالي الخصومات</span>
                                <span class="info-box-number">{{ number_format($invoices->sum('fat_disc'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-primary">
                            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">الصافي</span>
                                <span class="info-box-number">{{ number_format($invoices->sum('fat_net'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="background: white;">
                        <thead style="background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);color: white;">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">الوقت والتاريخ</th>
                                <th class="text-center">اسم العملية</th>
                                <th class="text-center">قيمة العملية</th>
                                <th class="text-center">مبلغ الخصم</th>
                                <th class="text-center">الصافي</th>
                                <th class="text-center">الحساب للقابل</th>
                                <th class="text-center">للمخزن</th>
                                <th class="text-center">الموظف</th>
                                <th class="text-center">معرف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                @php
                                    $index = $loop->index;
                                    $rowStyle = '';

                                @endphp
                                <tr style="border-bottom: 1px solid #e0e0e0;{{ $rowStyle }}">
                                    <td class="text-center">{{ $invoices->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->crtime)->format('Y/m/d H:i') }}</td>
                                    <td>
                                        @if ($invoice->pro_tybe == 12)
                                            <span class="badge badge-warning">أمر شراء</span>
                                            @if (!empty($invoice->converted_to_invoice))
                                                <br>
                                                <small class="text-success" style="font-weight: 600;">
                                                    <i class="fas fa-check-circle"></i> تم التحويل لفاتورة مشتريات
                                                </small>
                                            @endif
                                        @elseif ($invoice->pro_tybe == 11)
                                            <span class="badge badge-danger">مردود مشتريات</span>
                                        @else
                                            <span class="badge badge-success">فاتورة مشتريات</span>
                                        @endif
                                        @if ($invoice->info && str_contains($invoice->info, 'المورد:'))
                                            {{ trim(explode('المورد:', $invoice->info)[1] ?? 'غير محدد') }}
                                        @else
                                            {{ $invoice->info ?: ' ' }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ number_format($invoice->fat_total, 2) }}</td>
                                    <td class="text-center" style="color: #d32f2f;">
                                        {{ number_format($invoice->fat_disc, 2) }}</td>
                                    <td class="font-weight-bold text-center" style="color: #00897b;">
                                        {{ number_format($invoice->fat_net, 2) }}</td>
                                    <td class="text-center">
                                        @if ($invoice->acc1_name)
                                            {{ $invoice->acc1_name }}
                                        @elseif($invoice->acc1)
                                            حساب #{{ $invoice->acc1 }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($invoice->store_id)
                                            مخزن #{{ $invoice->store_id }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $invoice->user_name ?? 'غير محدد' }}</td>
                                    <td class="text-center">
                                        @if ($invoice->pro_tybe == 12 && empty($invoice->converted_to_invoice))
                                            <button class="btn btn-sm btn-success"
                                                onclick="convertToInvoice({{ $invoice->id }})" title="تحويل لفاتورة">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                        @endif

                                        <a href="{{ route('purchases.edit', $invoice->id) }}"
                                            class="btn btn-sm btn-success" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger"
                                            onclick="deleteInvoice({{ $invoice->id }})" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4" style="color: #999;">
                                        <i class="fas fa-inbox" style="font-size: 2em;"></i><br>
                                        لا توجد فواتير
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($invoices->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $invoices->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function convertToInvoice(id) {
            if (confirm('هل تريد تحويل أمر الشراء إلى فاتورة مشتريات؟\nسيتم تحديث المخزون بناءً على الأصناف المطلوبة.')) {
                fetch(`/purchases/convert-to-invoice/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            return response.json();
                        }
                    })
                    .then(data => {
                        if (data && data.success) {
                            alert('تم تحويل أمر الشراء بنجاح');
                            location.reload();
                        } else if (data && data.error) {
                            alert('حدث خطأ: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ في التحويل');
                    });
            }
        }

        function deleteInvoice(id) {
            if (confirm('هل أنت متأكد من حذف هذه الفاتورة؟')) {
                fetch(`/purchases/delete/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('تم حذف الفاتورة بنجاح');
                            location.reload();
                        } else {
                            alert('حدث خطأ: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ في الحذف');
                    });
            }
        }

        function printInvoice(id) {
            window.open(`/purchases/print/${id}`, '_blank');
        }
    </script>
@endsection
