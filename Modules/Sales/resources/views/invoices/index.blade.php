@extends('dashboard.layout')

@section('content')
    <div class="container-fluid p-2+">
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

                <div class="mb-3 text-left">
                    <a href="{{ route('sales.invoice') }}" class="btn btn-success"
                        style="background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);border: none;">
                        <i class="fas fa-plus"></i> فاتورة مبيعات جديدة
                    </a>
                    <a href="{{ route('sales.order') }}" class="btn btn-info"
                        style="background: linear-gradient(135deg, #29b6f6 0%, #0288d1 100%);border: none;">
                        <i class="fas fa-file-alt"></i> أمر بيع جديد
                    </a>
                    <a href="{{ route('sales.quotation') }}" class="btn btn-warning"
                        style="background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%);border: none;">
                        <i class="fas fa-quote-left"></i> عرض سعر جديد
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="background: white;">
                        <thead style="background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);color: white;">
                            <tr>
                                <th width="10%" class="text-center">رقم الفاتورة</th>
                                <th width="12%">التاريخ</th>
                                <th width="25%">العميل</th>
                                <th width="12%" class="text-center">الإجمالي</th>
                                <th width="12%" class="text-center">الخصم</th>
                                <th width="12%" class="text-center">الصافي</th>
                                <th width="17%" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr style="border-bottom: 1px solid #e0e0e0;">
                                    <td class="text-center font-weight-bold">{{ $invoice->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->pro_date)->format('Y-m-d') }}</td>
                                    <td>
                                        @php
                                            $client = DB::table('acc_head')->where('id', $invoice->acc2)->first();
                                        @endphp
                                        <span
                                            style="color: #00897b;font-weight: 600;">{{ $client->aname ?? 'غير محدد' }}</span>
                                    </td>
                                    <td class="text-center">{{ number_format($invoice->fat_total, 2) }}</td>
                                    <td class="text-center" style="color: #d32f2f;">
                                        {{ number_format($invoice->fat_disc, 2) }}</td>
                                    <td class="text-center font-weight-bold" style="color: #00897b;">
                                        {{ number_format($invoice->fat_net, 2) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('sales.edit', $invoice->id) }}" class="btn btn-sm btn-warning"
                                            title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" onclick="deleteInvoice({{ $invoice->id }})"
                                            title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="printInvoice({{ $invoice->id }})"
                                            title="طباعة">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4" style="color: #999;">
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
