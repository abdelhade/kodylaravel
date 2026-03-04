@extends('dashboard.layout')

@section('content')
    <div class="container-fluid p-2">
        <h4 class="font-thin text-md text-white text-center"
            style="font-size:2em;padding:15px;background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);border-radius: 10px 10px 0 0;margin:0;">
            فواتير المبيعات
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
                <form method="GET" action="{{ route('sales.index') }}" class="mb-3">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <label>من</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date', date('Y-m-01')) }}">
                        </div>
                        <div class="col-md-2">
                            <label>إلى</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-2">
                            <label>نوع العملية</label>
                            <select name="invoice_type" class="form-control">
                                <option value="">الكل</option>
                                <option value="3" {{ request('invoice_type') == '3' ? 'selected' : '' }}>فاتورة مبيعات</option>
                                <option value="8" {{ request('invoice_type') == '8' ? 'selected' : '' }}>أمر بيع</option>
                                <option value="12" {{ request('invoice_type') == '12' ? 'selected' : '' }}>عرض سعر</option>
                                <option value="9" {{ request('invoice_type') == '9' ? 'selected' : '' }}>نقطة بيع</option>
                                <option value="11" {{ request('invoice_type') == '11' ? 'selected' : '' }}>مردود مبيعات</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block" style="background: #4169E1;">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                        <div class="col-md-4 text-left">
                            <a href="{{ route('sales.invoice') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> فاتورة مبيعات
                            </a>
                            <a href="{{ route('sales.return') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-undo"></i> مردود
                            </a>
                            <a href="{{ route('sales.order') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-file-alt"></i> أمر بيع
                            </a>
                            <a href="{{ route('sales.quotation') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-handshake"></i> عرض سعر
                            </a>
                            <button onclick="window.print()" class="btn btn-secondary btn-sm">
                                <i class="fas fa-print"></i> طباعة
                            </button>
                        </div>
                    </div>
                </form>

                <!-- الإحصائيات -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-file-invoice"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">عدد الفواتير</span>
                                <span class="info-box-number">{{ $invoices->total() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">إجمالي المبيعات</span>
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
                            @forelse($invoices as $index => $invoice)
                                @php
                                    // تحديد نوع الفاتورة ولونها
                                    $invoiceType = '';
                                    $badgeColor = '';
                                    switch($invoice->pro_tybe) {
                                        case 3:
                                            $invoiceType = 'فاتورة مبيعات';
                                            $badgeColor = 'success';
                                            break;
                                        case 8:
                                            $invoiceType = 'أمر بيع';
                                            $badgeColor = 'warning';
                                            break;
                                        case 12:
                                            $invoiceType = 'عرض سعر';
                                            $badgeColor = 'primary';
                                            break;
                                        case 9:
                                            $invoiceType = 'نقطة بيع';
                                            $badgeColor = 'dark';
                                            break;
                                        case 11:
                                            $invoiceType = 'مردود مبيعات';
                                            $badgeColor = 'info';
                                            break;
                                        default:
                                            $invoiceType = 'غير محدد';
                                            $badgeColor = 'secondary';
                                    }
                                @endphp
                                <tr style="border-bottom: 1px solid #e0e0e0;">
                                    <td class="text-center">{{ $invoices->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->crtime)->format('Y/m/d H:i') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $badgeColor }}">{{ $invoiceType }}</span>
                                        @if ($invoice->info)
                                            <br><small>{{ $invoice->info }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ number_format($invoice->fat_total, 2) }}</td>
                                    <td class="text-center" style="color: #d32f2f;">{{ number_format($invoice->fat_disc, 2) }}</td>
                                    <td class="font-weight-bold text-center" style="color: #00897b;">{{ number_format($invoice->fat_net, 2) }}</td>
                                    <td class="text-center">
                                        @if($invoice->acc2_name)
                                            {{ $invoice->acc2_name }}
                                        @elseif($invoice->acc2)
                                            حساب #{{ $invoice->acc2 }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($invoice->store_id)
                                            مخزن #{{ $invoice->store_id }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $invoice->user_name ?? 'admin' }}</td>
                                    <td class="text-center">
                                        @if($invoice->pro_tybe == 8)
                                            {{-- زر تحويل لفاتورة (يظهر فقط لأوامر البيع) --}}
                                            <button class="btn btn-sm btn-success" 
                                                onclick="convertToInvoice({{ $invoice->id }})"
                                                title="تحويل لفاتورة مبيعات">
                                                <i class="fas fa-exchange-alt"></i> 
                                            </button>
                                        @endif
                                        
                                        @if($invoice->pro_tybe == 12)
                                            {{-- زر تحويل لفاتورة (يظهر فقط لعروض الأسعار) --}}
                                            <button class="btn btn-sm btn-primary" 
                                                onclick="convertQuotationToInvoice({{ $invoice->id }})"
                                                title="تحويل لفاتورة مبيعات">
                                                <i class="fas fa-file-invoice"></i> 
                                            </button>
                                        @endif
                                        
                                        <a href="{{ route('sales.edit', $invoice->id) }}"
                                            class="btn btn-sm btn-success" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" onclick="deleteInvoice({{ $invoice->id }})"
                                            title="حذف">
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
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    <script>
        function convertToInvoice(orderId) {
            if (confirm('هل تريد تحويل أمر البيع إلى فاتورة مبيعات؟\n\nسيتم:\n- إنشاء فاتورة مبيعات جديدة\n- خصم الكمية من المخزون\n- حذف أمر البيع')) {
                // إظهار رسالة تحميل
                const btn = event.target.closest('button');
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التحويل...';
                
                fetch(`/sales/convert-to-invoice/${orderId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('✅ ' + data.message + '\n\nرقم الفاتورة الجديدة: ' + data.invoice_id);
                            location.reload();
                        } else {
                            alert('❌ خطأ: ' + data.message);
                            btn.disabled = false;
                            btn.innerHTML = originalHtml;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('❌ حدث خطأ في التحويل');
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    });
            }
        }

        function convertQuotationToInvoice(quotationId) {
            if (confirm('هل تريد تحويل عرض السعر إلى فاتورة مبيعات؟\n\nسيتم:\n- إنشاء فاتورة مبيعات جديدة\n- خصم الكمية من المخزون\n- الاحتفاظ بعرض السعر للسجلات')) {
                // إظهار رسالة تحميل
                const btn = event.target.closest('button');
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التحويل...';
                
                fetch(`/sales/convert-quotation-to-invoice/${quotationId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('✅ ' + data.message + '\n\nرقم الفاتورة الجديدة: ' + data.invoice_id);
                            location.reload();
                        } else {
                            alert('❌ خطأ: ' + data.message);
                            btn.disabled = false;
                            btn.innerHTML = originalHtml;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('❌ حدث خطأ في التحويل');
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    });
            }
        }

        function deleteInvoice(id) {
            if (confirm('هل أنت متأكد من حذف هذه الفاتورة؟')) {
                fetch(`/sales/delete/${id}`, {
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
            window.open(`/sales/print/${id}`, '_blank');
        }
    </script>
@endsection
