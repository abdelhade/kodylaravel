@extends('layouts.master')

@section('title', 'نظام نقاط البيع')

@section('content')
<div class="container-fluid">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('pos.index') }}">
                <i class="fas fa-cash-register me-2"></i>نظام نقاط البيع
            </a>
            <div class="ms-auto">
                <button class="btn btn-outline-light btn-sm me-2" id="fullscreenBtn" title="ملء الشاشة">
                    <i class="fas fa-expand-arrows-alt"></i>
                </button>
                <button type="button" class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#closeShiftModal">
                    <i class="fas fa-power-off me-1"></i> إغلاق الشيفت
                </button>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i>تسجيل الخروج
                </a>
            </div>
        </div>
    </nav>

    <div class="row">
        <!-- الطاولات -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-table me-2"></i>الطاولات</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3" id="tablesContainer">
                        @forelse($tables as $table)
                            <div class="col-md-4 col-lg-3">
                                <button class="btn btn-outline-secondary w-100 table-btn" 
                                        data-table-id="{{ $table->id }}"
                                        data-table-name="{{ $table->tname }}"
                                        style="height: 80px; font-size: 14px;">
                                    <div>{{ $table->tname }}</div>
                                    <small class="text-muted">{{ $table->getStatusLabel() }}</small>
                                </button>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center text-muted">لا توجد طاولات متاحة</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- الطلب الحالي -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>الطلب الحالي</h5>
                </div>
                <div class="card-body">
                    <!-- البحث عن الصنف -->
                    <div class="mb-3">
                        <label class="form-label">البحث بالباركود</label>
                        <input type="text" class="form-control" id="barcodeInput" placeholder="أدخل الباركود أو الكود">
                    </div>

                    <!-- قائمة الأصناف -->
                    <div id="itemsList" style="max-height: 300px; overflow-y: auto;">
                        <p class="text-center text-muted">لا توجد أصناف</p>
                    </div>

                    <!-- الإجماليات -->
                    <div class="mt-3 pt-3 border-top">
                        <div class="row mb-2">
                            <div class="col-6">الإجمالي:</div>
                            <div class="col-6 text-end"><strong id="totalAmount">0.00</strong></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">الخصم:</div>
                            <div class="col-6 text-end">
                                <input type="number" class="form-control form-control-sm" id="discountAmount" value="0" min="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">الصافي:</div>
                            <div class="col-6 text-end"><strong id="netAmount">0.00</strong></div>
                        </div>
                        <button class="btn btn-success w-100" id="saveOrderBtn">
                            <i class="fas fa-save me-2"></i>حفظ الطلب
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal إغلاق الشيفت -->
<div class="modal fade" id="closeShiftModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إغلاق الشيفت</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من رغبتك في إغلاق الشيفت الحالي؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form action="{{ route('pos.close-shift') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">إغلاق الشيفت</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentOrder = [];
    let selectedTableId = null;

    // البحث عن الصنف
    document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const barcode = this.value.trim();
            if (barcode) {
                searchItem(barcode);
                this.value = '';
            }
        }
    });

    function searchItem(barcode) {
        fetch('{{ route("pos.search-item") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ barcode: barcode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                addItemToOrder(data);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function addItemToOrder(item) {
        const existingItem = currentOrder.find(i => i.id === item.id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            currentOrder.push({
                id: item.id,
                name: item.aname,
                price: item.price || 0,
                quantity: 1
            });
        }
        updateOrderDisplay();
    }

    function updateOrderDisplay() {
        const itemsList = document.getElementById('itemsList');
        if (currentOrder.length === 0) {
            itemsList.innerHTML = '<p class="text-center text-muted">لا توجد أصناف</p>';
            return;
        }

        let html = '<div class="list-group">';
        let total = 0;

        currentOrder.forEach((item, index) => {
            const itemTotal = item.quantity * item.price;
            total += itemTotal;
            html += `
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${item.name}</strong><br>
                            <small class="text-muted">${item.price.toFixed(2)} × ${item.quantity}</small>
                        </div>
                        <div class="text-end">
                            <div>${itemTotal.toFixed(2)}</div>
                            <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        html += '</div>';
        itemsList.innerHTML = html;

        document.getElementById('totalAmount').textContent = total.toFixed(2);
        updateNetAmount();
    }

    window.removeItem = function(index) {
        currentOrder.splice(index, 1);
        updateOrderDisplay();
    };

    function updateNetAmount() {
        const total = parseFloat(document.getElementById('totalAmount').textContent);
        const discount = parseFloat(document.getElementById('discountAmount').value) || 0;
        const net = total - discount;
        document.getElementById('netAmount').textContent = net.toFixed(2);
    }

    document.getElementById('discountAmount').addEventListener('change', updateNetAmount);

    document.getElementById('saveOrderBtn').addEventListener('click', function() {
        if (currentOrder.length === 0) {
            alert('يجب إضافة صنف واحد على الأقل');
            return;
        }

        const total = parseFloat(document.getElementById('totalAmount').textContent);
        const discount = parseFloat(document.getElementById('discountAmount').value) || 0;

        fetch('{{ route("pos.save-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                table_id: selectedTableId,
                order_type: 1,
                items: currentOrder,
                total: total,
                discount: discount,
                notes: ''
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم حفظ الطلب بنجاح');
                currentOrder = [];
                updateOrderDisplay();
            } else {
                alert('خطأ: ' + data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // ملء الشاشة
    document.getElementById('fullscreenBtn').addEventListener('click', function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    });
});
</script>
@endpush
@endsection
