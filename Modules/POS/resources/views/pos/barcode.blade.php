<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>نظام نقاط البيع - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-home me-2"></i>
                <i class="fas fa-cash-register me-2"></i>نظام نقاط البيع
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">

                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="btn btn-outline-light btn-sm me-2" id="fullscreenBtn" title="ملء الشاشة">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </button>

                        <button type="button" class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#closeShiftModal" title="إغلاق الشيفت">
                            <i class="fas fa-power-off me-1"></i> إغلاق الشيفت
                        </button>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="fas fa-sign-out-alt me-1"></i>تسجيل الخروج
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- رسالة النجاح -->
    @if(session('success'))
    <div class="container-fluid mt-2">
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <script>
        setTimeout(function () {
            var alert = document.getElementById('successAlert');
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
    @endif

    <!-- Main Content -->
    <form action="{{ route('pos.save-order') }}" method="post" id="posForm" onsubmit="return handleFormSubmit(this);">
        @csrf
        <div class="container-fluid h-100" style="height: calc(100vh - 60px);">
            <div class="row h-100 g-1">
                <!-- القسم الأيمن - معلومات الطلب -->
                <div class="col-lg-4">
                    <div class="card shadow-sm h-100 d-flex flex-column">
                        <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-shopping-cart me-2"></i>معلومات الطلب
                            </h6>
                            <button type="button" id="recentOrdersBtn2" class="btn btn-light btn-sm recent-orders-btn">
                                <i class="fas fa-history me-1"></i> عرض الطلبات السابقة
                            </button>
                        </div>
                        <div class="card-body flex-grow-1 overflow-auto d-flex flex-column">
                            <!-- Hidden Fields -->
                            <input type="hidden" name="pro_tybe" value="9">
                            <input type="hidden" name="pro_serial" value="0">
                            <input type="hidden" name="pro_id" value="1">

                            <!-- نوع الطلب -->
                            <div class="mb-2">
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" id="age1" name="age" value="1" 
                                        {{ (!$editOrder || ($editOrder->age ?? 1) == 1) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary btn-sm" for="age1">
                                        <i class="fas fa-shopping-bag me-1"></i>تيك أواي
                                    </label>

                                    <input type="radio" class="btn-check" id="age2" name="age" value="2" 
                                        {{ (request('table') || ($editOrder && ($editOrder->age ?? 0) == 2)) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary btn-sm" for="age2">
                                        <i class="fas fa-chair me-1"></i>طاولة
                                    </label>

                                    <input type="radio" class="btn-check" id="age3" name="age" value="3"
                                        {{ ($editOrder && ($editOrder->age ?? 0) == 3) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary btn-sm" for="age3" onclick="openDeliveryModal()">
                                        <i class="fas fa-motorcycle me-1"></i>دليفري
                                    </label>
                                </div>
                            </div>

                            <!-- الباركود والبحث -->
                            <div class="row g-1 mb-2">
                                <!-- البحث -->
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="scnd form-control" id="searchInput"
                                            placeholder="ابحث عن الصنف..."
                                            title="ابحث عن الصنف واضغط Enter | Alt+S للتركيز">
                                    </div>
                                </div>

                                <!-- الباركود -->
                                <div class="col-6">
                                    <input type="text" class="form-control form-control-sm frst"
                                        placeholder="امسح الباركود..." id="barcodeInput"
                                        title="قارئ الباركود | Alt+B للتركيز"
                                        style="border: 2px solid #28a745; background: #f8fff8;">
                                </div>
                            </div>

                            <!-- الحقول الثانوية -->
                            <div class="row g-1 mb-2">
                                <!-- التواريخ -->
                                <div class="col-4">
                                    <input type="date" name="pro_date" class="form-control form-control-sm"
                                        value="{{ $posdate }}" title="التاريخ" style="font-size: 0.75rem;">
                                </div>
                                <div class="col-4">
                                    <input type="date" name="accural_date" class="form-control form-control-sm"
                                        value="{{ $editOrder->accural_date ?? date('Y-m-d') }}"
                                        title="تاريخ الاستحقاق" style="font-size: 0.75rem;">
                                </div>

                                <!-- اختيار الطاولة -->
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100"
                                        data-bs-toggle="modal" data-bs-target="#tablesModal" title="اختر الطاولة"
                                        style="font-size: 0.75rem;">
                                        <i class="fas fa-chair me-1"></i>
                                        <span id="selected_table_display">اختر طاولة</span>
                                    </button>
                                    <input type="hidden" id="selected_table_id" name="table_id" value="0">
                                    <input type="hidden" id="selected_table_name" name="table_name" value="">
                                    <input type="hidden" id="selected_order_id" name="edit" value="0">
                                </div>
                            </div>

                            <!-- الحقول الصغيرة -->
                            <div class="row g-1 mb-2">
                                <!-- المخزن -->
                                <div class="col-3">
                                    <select name="store_id" class="form-select form-select-sm" title="المخزن"
                                        style="font-size: 0.75rem;" required>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}" 
                                                {{ ($settings->def_pos_store ?? null) == $store->id ? 'selected' : '' }}>
                                                {{ $store->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- الموظف -->
                                <div class="col-3">
                                    <select name="emp_id" class="form-select form-select-sm" title="الموظف"
                                        style="font-size: 0.75rem;" required>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" 
                                                {{ ($settings->def_pos_employee ?? ($editOrder->emp_id ?? null)) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- العميل -->
                                <div class="col-3">
                                    <select name="acc2_id" class="form-select form-select-sm" title="العميل"
                                        style="font-size: 0.75rem;" required>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" 
                                                {{ ($settings->def_pos_client ?? ($editOrder->acc1 ?? null)) == $client->id ? 'selected' : '' }}>
                                                {{ $client->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- الصندوق -->
                                <div class="col-3">
                                    <select name="fund_id" class="form-select form-select-sm" title="الصندوق"
                                        style="font-size: 0.75rem;" required>
                                        @foreach($funds as $fund)
                                            <option value="{{ $fund->id }}" 
                                                {{ ($settings->def_pos_fund ?? ($editOrder->acc_fund ?? null)) == $fund->id ? 'selected' : '' }}>
                                                {{ $fund->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- الأصناف المُضافة -->
                            <div class="mb-2 flex-grow-1 d-flex flex-column">
                                <div class="card flex-grow-1 d-flex flex-column border-primary">
                                    <div class="card-header bg-gradient bg-primary text-white py-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0" style="font-size: 0.95rem;">
                                                <i class="fas fa-shopping-cart me-2"></i>الأصناف المُضافة
                                            </h6>
                                            <span class="badge bg-white text-primary" id="itemCount">0</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-1 flex-grow-1"
                                        style="min-height: 40vh; max-height: 40vh; overflow-y: auto; overflow-x: auto; background: #f8f9fa;"
                                        id="itemData">
                                        @if($editOrder)
                                            @php
                                                $details = DB::table('fat_details as fd')
                                                    ->leftJoin('myitems as m', 'm.id', '=', 'fd.item_id')
                                                    ->where('fd.fat_id', $editOrder->id)
                                                    ->select('fd.*', 'm.iname as item_name', 'm.barcode')
                                                    ->get();
                                                $x = 0;
                                            @endphp
                                            @foreach($details as $detail)
                                                @php
                                                    $x++;
                                                    $item_name = $detail->item_name ?: 'صنف غير معروف';
                                                    $qty = floatval($detail->quantity);
                                                    $price = floatval($detail->price);
                                                    $subtotal = floatval($detail->total);
                                                    $barcode = $detail->barcode ?: $detail->item_id;
                                                @endphp
                                                <div class="card mb-1 item-card-order shadow-sm border-start border-3"
                                                    data-itemid="{{ $barcode }}"
                                                    style="border-color: #0a7ea4 !important; max-width: 100%;">
                                                    <div class="card-body p-1">
                                                        <div class="d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                                            <span class="badge bg-primary" style="font-size: 0.7rem; min-width: 25px;">#{{ $x }}</span>

                                                            <div style="flex: 1; min-width: 0;">
                                                                <input type="hidden" value='{{ $detail->item_id }}' name="itmname[]">
                                                                <input type="hidden" class="barcode" value="{{ $barcode }}">
                                                                <div class="text-truncate fw-bold" style="font-size: 0.75rem;"
                                                                    title="{{ $item_name }}">{{ $item_name }}</div>
                                                            </div>

                                                            <div style="width: 65px;">
                                                                <small class="d-block text-center text-muted"
                                                                    style="font-size: 0.6rem; margin-bottom: 1px;">كمية</small>
                                                                <input type="number"
                                                                    class="form-control form-control-sm text-center quantityInput nozero fw-bold"
                                                                    value="{{ $qty }}" name="itmqty[]" min="1" step="0.1"
                                                                    style="width: 100%; font-size: 0.75rem; padding: 3px; border: 2px solid #ff6347; height: 26px;"
                                                                    title="الكمية">
                                                                <input type="hidden" name="u_val[]" value="1">
                                                            </div>

                                                            <div style="width: 55px;">
                                                                <small class="d-block text-center text-muted"
                                                                    style="font-size: 0.6rem; margin-bottom: 1px;">سعر</small>
                                                                <input type="number"
                                                                    class="form-control form-control-sm text-center priceInput nozero"
                                                                    value="{{ number_format($price, 2, '.', '') }}"
                                                                    name="itmprice[]" step="0.01"
                                                                    style="width: 100%; font-size: 0.7rem; padding: 3px; height: 26px;"
                                                                    title="السعر">
                                                            </div>

                                                            <div style="width: 60px;">
                                                                <small class="d-block text-center text-muted"
                                                                    style="font-size: 0.6rem; margin-bottom: 1px;">قيمة</small>
                                                                <input type="hidden" name="itmdisc[]" value="0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm text-center subtotal fw-bold"
                                                                    readonly value="{{ number_format($subtotal, 2, '.', '') }}"
                                                                    name="itmval[]"
                                                                    style="width: 100%; font-size: 0.7rem; padding: 3px; background: #fff3cd; height: 26px;"
                                                                    title="القيمة">
                                                            </div>

                                                            <button type="button" class="btn btn-danger btn-sm delRow"
                                                                style="padding: 2px 6px; font-size: 0.7rem;" title="حذف">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- قسم الدفع والحسابات -->
                            <div class="card border-primary mt-1">
                                <div class="card-header bg-primary text-white py-1">
                                    <h6 class="mb-0" style="font-size: 0.8rem;">
                                        <i class="fas fa-calculator me-1"></i>الحسابات والدفع
                                    </h6>
                                </div>
                                <div class="card-body p-1">
                                    <!-- الإجمالي والصافي -->
                                    <div class="row g-1 mb-1">
                                        <div class="col-6 text-center">
                                            <small class="text-muted d-block" style="font-size: 0.65rem;">الإجمالي</small>
                                            <h5 class="mb-0 text-primary" id="total_display" style="font-size: 0.9rem;">0.00 ج.م</h5>
                                            <input type="hidden" name="headtotal" id="total" value="0.00">
                                            <input name="headplus" type="hidden">
                                        </div>
                                        <div class="col-6 text-center">
                                            <small class="text-muted d-block" style="font-size: 0.65rem;">الصافي</small>
                                            <h5 class="mb-0 text-success" id="net_display" style="font-size: 0.9rem;">0.00 ج.م</h5>
                                            <input type="hidden" name="headnet" id="net_val" value="0">
                                            <input type="hidden" name="headdisc" id="discount" value="0">
                                        </div>
                                    </div>

                                    <!-- ملاحظات -->
                                    <div class="mb-1">
                                        <textarea class="form-control form-control-sm" name="info" id="info" rows="1"
                                            placeholder="ملاحظات..."
                                            style="font-size: 0.7rem; padding: 0.2rem;">{{ $editOrder->info ?? '' }}</textarea>
                                    </div>

                                    <!-- أزرار الإجراءات -->
                                    <div class="d-flex gap-1 justify-content-between align-items-center">
                                        <button type="button" class="btn btn-primary flex-grow-1" data-bs-toggle="modal"
                                            data-bs-target="#paymentModal" style="font-size: 0.8rem; padding: 0.4rem;">
                                            <i class="fas fa-money-bill-wave me-1"></i>دفع وحفظ
                                            <div style="font-size: 0.7rem; font-weight: bold;" id="total_display_btn">0.00 ج.م</div>
                                        </button>
                                        <div class="d-flex align-items-center gap-1">
                                            <div id="selectedTableDisplay" class="badge bg-primary text-white"
                                                style="font-size: 0.8rem; display: none;">
                                                <i class="fas fa-chair me-1"></i><span id="selectedTableName"></span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger"
                                            style="font-size: 0.7rem; padding: 0.4rem 0.6rem;"
                                            onclick="clearAllItems();" title="مسح">
                                            <i class="fas fa-eraser"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- القسم الأيسر - الأصناف -->
                <div class="col-lg-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-box me-2"></i>الأصناف المتاحة
                                </h6>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" class="form-control" id="itemFilterInput" 
                                            placeholder="بحث سريع...">
                                        <button class="btn btn-outline-light" type="button" id="clearFilter">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-2" style="overflow-y: auto; max-height: calc(100vh - 140px);">
                            <!-- Categories -->
                            <div class="mb-2">
                                <div class="btn-group flex-wrap" role="group">
                                    <button type="button" class="btn btn-primary btn-sm category-btn active" data-category="all">
                                        <i class="fas fa-th me-1"></i>الكل
                                    </button>
                                    @php
                                        try {
                                            // جلب المجموعات من acc_head
                                            $categories = DB::table('acc_head')
                                                ->where('parent_id', 16)
                                                ->where('isdeleted', 0)
                                                ->select('id', 'aname')
                                                ->get();
                                        } catch (\Exception $e) {
                                            $categories = collect([]);
                                        }
                                    @endphp
                                    @foreach($categories as $category)
                                        <button type="button" class="btn btn-outline-primary btn-sm category-btn" 
                                            data-category="{{ $category->id }}">
                                            {{ $category->aname }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Items Grid -->
                            <div class="row g-2" id="itemsContainer">
                                @php
                                    try {
                                        $items = DB::table('myitems as m')
                                            ->where('m.isdeleted', 0)
                                            ->select('m.*')
                                            ->orderBy('m.iname')
                                            ->get();
                                    } catch (\Exception $e) {
                                        $items = collect([]);
                                    }
                                @endphp
                                @if($items->count() > 0)
                                    @foreach($items as $item)
                                        <div class="col-6 col-md-4 col-lg-3 col-xl-2 item-wrapper" 
                                            data-category="{{ $item->group1 ?? '' }}">
                                            <div class="card item-card h-100 shadow-sm" 
                                                data-item-id="{{ $item->id }}"
                                                data-item-name="{{ $item->iname }}"
                                                data-item-barcode="{{ $item->barcode ?? '' }}"
                                                data-item-price="{{ $item->price1 ?? 0 }}"
                                                onclick="addItemToOrder(this)"
                                                style="cursor: pointer;">
                                                <div class="card-body p-2 text-center">
                                                    @if(!empty($item->image))
                                                        <img src="{{ asset('uploads/items/' . $item->image) }}" 
                                                            class="img-fluid mb-2" style="max-height: 60px;" 
                                                            alt="{{ $item->iname }}">
                                                    @else
                                                        <i class="fas fa-box fa-3x text-muted mb-2"></i>
                                                    @endif
                                                    <h6 class="card-title mb-1" style="font-size: 0.8rem;">{{ $item->iname }}</h6>
                                                    <p class="card-text mb-0">
                                                        <span class="badge bg-success">{{ number_format($item->price1 ?? 0, 2) }} ج.م</span>
                                                    </p>
                                                    @if(!empty($item->barcode))
                                                        <small class="text-muted d-block" style="font-size: 0.7rem;">{{ $item->barcode }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center py-5">
                                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">لا توجد أصناف متاحة</h5>
                                        <p class="text-muted">يرجى إضافة أصناف من قائمة المخزون</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modals and Scripts will be added here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // دالة إضافة صنف للطلب
        function addItemToOrder(elementOrId, itemName, quantity, price, index) {
            // التحقق من نوع الـ parameter الأول
            if (typeof elementOrId === 'object' && elementOrId.getAttribute) {
                // تم استدعاء الـ function من الـ onclick - element
                const element = elementOrId;
                console.log('addItemToOrder called with element', element);
                const itemId = element.getAttribute('data-item-id');
                const itemNameVal = element.getAttribute('data-item-name');
                const itemBarcode = element.getAttribute('data-item-barcode') || itemId;
                const itemPriceAttr = element.getAttribute('data-item-price');
                const itemPriceVal = parseFloat(itemPriceAttr) || 0;
                
                console.log('Item data:', {itemId, itemName: itemNameVal, itemBarcode, itemPrice: itemPriceVal});
                
                if (!itemId || !itemNameVal) {
                    console.error('Missing item data');
                    alert('خطأ: بيانات الصنف غير مكتملة');
                    return;
                }
                
                // التحقق من وجود الصنف مسبقاً
                const existingItem = document.querySelector(`#itemData .item-card-order[data-itemid="${itemBarcode}"]`);
                
                if (existingItem) {
                    // زيادة الكمية إذا كان الصنف موجود
                    const qtyInput = existingItem.querySelector('.quantityInput');
                    const currentQty = parseFloat(qtyInput.value) || 0;
                    qtyInput.value = currentQty + 1;
                    
                    // تحديث القيمة
                    updateItemTotal(existingItem);
                } else {
                    // إضافة صنف جديد
                    addNewItemRow(itemId, itemNameVal, itemBarcode, itemPriceVal);
                }
                
                // تحديث الإجمالي
                updateTotals();
            } else {
                // تم استدعاء الـ function من editOrder - parameters منفصلة
                const itemId = elementOrId;
                const itemBarcode = itemId;
                const itemPrice = parseFloat(price) || 0;
                const qty = parseFloat(quantity) || 1;
                
                console.log('addItemToOrder called with params', {itemId, itemName, qty, itemPrice});
                
                // التحقق من وجود الصنف مسبقاً
                const existingItem = document.querySelector(`#itemData .item-card-order[data-itemid="${itemBarcode}"]`);
                
                if (existingItem) {
                    // زيادة الكمية إذا كان الصنف موجود
                    const qtyInput = existingItem.querySelector('.quantityInput');
                    const currentQty = parseFloat(qtyInput.value) || 0;
                    qtyInput.value = currentQty + qty;
                    
                    // تحديث القيمة
                    updateItemTotal(existingItem);
                } else {
                    // إضافة صنف جديد مباشرة
                    addNewItemRow(itemId, itemName, itemBarcode, itemPrice, qty);
                }
                
                // تحديث الإجمالي
                updateTotals();
            }
        }
        
        // دالة إضافة صف جديد
        function addNewItemRow(itemId, itemName, itemBarcode, itemPrice, quantity) {
            const itemData = document.getElementById('itemData');
            const itemCount = itemData.querySelectorAll('.item-card-order').length + 1;
            
            // التأكد من القيم
            itemPrice = parseFloat(itemPrice) || 0;
            itemBarcode = itemBarcode || itemId;
            quantity = parseFloat(quantity) || 1;
            const subtotal = quantity * itemPrice;
            
            const itemHtml = `
                <div class="card mb-1 item-card-order shadow-sm border-start border-3"
                    data-itemid="${itemBarcode}"
                    style="border-color: #0a7ea4 !important; max-width: 100%;">
                    <div class="card-body p-1">
                        <div class="d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                            <span class="badge bg-primary" style="font-size: 0.7rem; min-width: 25px;">#${itemCount}</span>

                            <div style="flex: 1; min-width: 0;">
                                <input type="hidden" value='${itemId}' name="itmname[]">
                                <input type="hidden" class="barcode" value="${itemBarcode}">
                                <div class="text-truncate fw-bold" style="font-size: 0.75rem;"
                                    title="${itemName}">${itemName}</div>
                            </div>

                            <div style="width: 65px;">
                                <small class="d-block text-center text-muted"
                                    style="font-size: 0.6rem; margin-bottom: 1px;">كمية</small>
                                <input type="number"
                                    class="form-control form-control-sm text-center quantityInput nozero fw-bold"
                                    value="${quantity}" name="itmqty[]" min="1" step="0.1"
                                    style="width: 100%; font-size: 0.75rem; padding: 3px; border: 2px solid #ff6347; height: 26px;"
                                    title="الكمية" onchange="updateItemTotal(this.closest('.item-card-order'))">
                                <input type="hidden" name="u_val[]" value="1">
                            </div>

                            <div style="width: 55px;">
                                <small class="d-block text-center text-muted"
                                    style="font-size: 0.6rem; margin-bottom: 1px;">سعر</small>
                                <input type="number"
                                    class="form-control form-control-sm text-center priceInput nozero"
                                    value="${itemPrice.toFixed(2)}"
                                    name="itmprice[]" step="0.01"
                                    style="width: 100%; font-size: 0.7rem; padding: 3px; height: 26px;"
                                    title="السعر" onchange="updateItemTotal(this.closest('.item-card-order'))">
                            </div>

                            <div style="width: 60px;">
                                <small class="d-block text-center text-muted"
                                    style="font-size: 0.6rem; margin-bottom: 1px;">قيمة</small>
                                <input type="hidden" name="itmdisc[]" value="0">
                                <input type="text"
                                    class="form-control form-control-sm text-center subtotal fw-bold"
                                    readonly value="${subtotal.toFixed(2)}"
                                    name="itmval[]"
                                    style="width: 100%; font-size: 0.7rem; padding: 3px; background: #fff3cd; height: 26px;"
                                    title="القيمة">
                            </div>

                            <button type="button" class="btn btn-danger btn-sm delRow"
                                style="padding: 2px 6px; font-size: 0.7rem;" title="حذف"
                                onclick="removeItem(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            itemData.insertAdjacentHTML('beforeend', itemHtml);
            updateTotals();
        }
        
        // دالة تحديث قيمة الصنف
        function updateItemTotal(itemCard) {
            const qtyInput = itemCard.querySelector('.quantityInput');
            const priceInput = itemCard.querySelector('.priceInput');
            const subtotalInput = itemCard.querySelector('.subtotal');
            
            const qty = parseFloat(qtyInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const subtotal = qty * price;
            
            subtotalInput.value = subtotal.toFixed(2);
            updateTotals();
        }
        
        // دالة حذف صنف
        function removeItem(button) {
            const itemCard = button.closest('.item-card-order');
            itemCard.remove();
            updateTotals();
            updateItemNumbers();
        }
        
        // دالة تحديث أرقام الأصناف
        function updateItemNumbers() {
            const items = document.querySelectorAll('#itemData .item-card-order');
            items.forEach((item, index) => {
                const badge = item.querySelector('.badge');
                badge.textContent = '#' + (index + 1);
            });
        }
        
        // دالة تحديث الإجماليات
        function updateTotals() {
            const items = document.querySelectorAll('#itemData .item-card-order');
            let total = 0;
            
            items.forEach(item => {
                const subtotal = parseFloat(item.querySelector('.subtotal').value) || 0;
                total += subtotal;
            });
            
            // تحديث عدد الأصناف
            document.getElementById('itemCount').textContent = items.length;
            
            // تحديث الإجمالي
            document.getElementById('total').value = total.toFixed(2);
            document.getElementById('total_display').textContent = total.toFixed(2) + ' ج.م';
            document.getElementById('total_display_btn').textContent = total.toFixed(2) + ' ج.م';
            
            // تحديث الصافي (بدون خصم حالياً)
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const net = total - discount;
            document.getElementById('net_val').value = net.toFixed(2);
            document.getElementById('net_display').textContent = net.toFixed(2) + ' ج.م';
        }
        
        // دالة مسح كل الأصناف
        function clearAllItems() {
            if (confirm('هل أنت متأكد من مسح جميع الأصناف؟')) {
                document.getElementById('itemData').innerHTML = '';
                updateTotals();
            }
        }
        
        // دالة التعامل مع إرسال النموذج
        function handleFormSubmit(form) {
            const items = document.querySelectorAll('#itemData .item-card-order');
            if (items.length === 0) {
                alert('يرجى إضافة أصناف للطلب');
                return false;
            }
            return true;
        }
        
        // البحث في الأصناف
        $(document).ready(function() {
            // Setup CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // البحث بالباركود
            $('#barcodeInput').on('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const barcode = $(this).val().trim();
                    if (barcode) {
                        searchItemByBarcode(barcode);
                        $(this).val('');
                    }
                }
            });
            
            // البحث بالاسم
            $('#searchInput').on('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const search = $(this).val().trim();
                    if (search) {
                        searchItemByName(search);
                    }
                }
            });
            
            // اختصارات لوحة المفاتيح
            $(document).keydown(function(e) {
                if (e.key === 'F1') {
                    e.preventDefault();
                    $('#barcodeInput').focus();
                } else if (e.key === 'F2') {
                    e.preventDefault();
                    $('#searchInput').focus();
                }
            });
            
            $('#itemFilterInput').on('keyup input', function() {
                const searchText = $(this).val().toLowerCase();
                
                if (searchText === '') {
                    $('.item-wrapper').show();
                    return;
                }
                
                $('.item-wrapper').each(function() {
                    const itemName = $(this).find('[data-item-name]').attr('data-item-name');
                    const itemBarcode = $(this).find('[data-item-barcode]').attr('data-item-barcode');
                    
                    if ((itemName && itemName.toLowerCase().indexOf(searchText) >= 0) ||
                        (itemBarcode && itemBarcode.toLowerCase().indexOf(searchText) >= 0)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            
            $('#clearFilter').click(function() {
                $('#itemFilterInput').val('');
                $('.item-wrapper').show();
            });
            
            // فلترة التصنيفات
            $('.category-btn').click(function(e) {
                e.preventDefault();
                
                $('.category-btn').removeClass('active btn-primary').addClass('btn-outline-primary');
                $(this).removeClass('btn-outline-primary').addClass('btn-primary active');
                
                const categoryId = $(this).data('category');
                
                $('#itemFilterInput').val('');
                
                if (categoryId === 'all') {
                    $('.item-wrapper').show();
                } else {
                    $('.item-wrapper').hide();
                    $('.item-wrapper[data-category="' + categoryId + '"]').show();
                }
            });
            
            // ملء الشاشة
            $('#fullscreenBtn').click(function() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
            });
            
            // الطلبات السابقة
            $('.recent-orders-btn, #recentOrdersBtn2').click(function() {
                loadRecentOrders();
            });
        });
        
        // البحث عن صنف بالباركود
        function searchItemByBarcode(barcode) {
            // البحث في الأصناف المعروضة
            const items = document.querySelectorAll('.item-card');
            let found = false;
            
            items.forEach(item => {
                const itemBarcode = item.getAttribute('data-item-barcode');
                const itemId = item.getAttribute('data-item-id');
                
                if (itemBarcode === barcode || itemId === barcode) {
                    // إضافة الصنف
                    addItemToOrder(item);
                    found = true;
                    
                    // تمييز الصنف مؤقتاً
                    item.style.border = '3px solid #28a745';
                    setTimeout(() => {
                        item.style.border = '';
                    }, 1000);
                }
            });
            
            if (!found) {
                alert('الصنف غير موجود: ' + barcode);
            }
        }
        
        // البحث عن صنف بالاسم
        function searchItemByName(search) {
            $('#itemFilterInput').val(search);
            $('#itemFilterInput').trigger('input');
        }
        
        // تحميل الطلبات السابقة
        function loadRecentOrders() {
            const offcanvas = new bootstrap.Offcanvas(document.getElementById('recentOrdersModal'));
            offcanvas.show();
            
            $('#recentOrdersList').html(`
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <p class="mt-2">جاري تحميل الطلبات...</p>
                    </td>
                </tr>
            `);
            
            // جلب الطلبات من السيرفر
            fetch("{{ route('pos.recent-orders') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.orders.length > 0) {
                        let html = '';
                        data.orders.forEach((order, index) => {
                            // تحديد نوع الطلب
                            let orderType = '';
                            if (order.age == 1) {
                                orderType = '<span class="badge bg-primary">تيك اوي</span>';
                            } else if (order.age == 2) {
                                orderType = '<span class="badge bg-info">طاولة</span>';
                            } else if (order.age == 3) {
                                orderType = '<span class="badge bg-warning">دليفري</span>';
                            } else {
                                orderType = '<span class="badge bg-secondary">غير محدد</span>';
                            }
                            
                            // تنسيق التاريخ والوقت
                            let orderDate = new Date(order.crtime);
                            
                            // التحقق من صحة التاريخ
                            if (isNaN(orderDate.getTime())) {
                                // إذا كان التاريخ غير صحيح، استخدم التاريخ الحالي
                                orderDate = new Date();
                            }
                            
                            let dateStr = orderDate.toLocaleDateString('ar-EG', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit'
                            });
                            
                            let timeStr = orderDate.toLocaleTimeString('ar-EG', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            });
                            
                            html += `
                                <tr class="text-center">
                                    <td>${index + 1}</td>
                                    <td><strong>${order.id}</strong></td>
                                    <td>${timeStr}<br><small class="text-muted">${dateStr}</small></td>
                                    <td>${order.client_name || 'عميل نقدي'}</td>
                                    <td>${orderType}</td>
                                    <td><strong class="text-primary">${parseFloat(order.fat_net).toFixed(2)} ج.م</strong></td>
                                    <td><span class="badge bg-success">مكتمل</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-danger" onclick="deleteOrder(${order.id})" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-info" onclick="printOrder(${order.id})" title="طباعة">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            <button class="btn btn-warning" onclick="editOrder(${order.id})" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#recentOrdersList').html(html);
                    } else {
                        $('#recentOrdersList').html(`
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">لا توجد طلبات سابقة</p>
                                </td>
                            </tr>
                        `);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    $('#recentOrdersList').html(`
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                <p class="text-danger">حدث خطأ في تحميل الطلبات</p>
                            </td>
                        </tr>
                    `);
                });
        }
        
        // تعديل الطلب
        function editOrder(orderId) {
            // جلب تفاصيل الطلب
            fetch("{{ route('pos.recent-orders') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const order = data.orders.find(o => o.id == orderId);
                        if (order && order.items) {
                            // مسح الطلب الحالي
                            $('#itemData').empty();
                            
                            // إضافة أصناف الطلب للتعديل
                            order.items.forEach((item, index) => {
                                addItemToOrder(item.item_id, item.item_name, item.quantity, item.price, index + 1);
                            });
                            
                            // حساب الإجمالي
                            recalculateTotal();
                            
                            // تحديد نوع الطلب
                            if (order.age) {
                                $('input[name="age"][value="' + order.age + '"]').prop('checked', true);
                            }
                            
                            // إضافة معرف الطلب للتعديل
                            $('input[name="edit"]').val(orderId);
                            
                            // إغلاق نافذة الطلبات السابقة
                            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('recentOrdersModal'));
                            if (offcanvas) {
                                offcanvas.hide();
                            }
                            
                            alert('تم تحميل الطلب للتعديل');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ في تحميل الطلب');
                });
        }
        
        // حذف بطاقة صنف
        function removeItemCard(btn) {
            removeItem(btn);
        }
        
        // إعادة حساب الإجمالي
        function recalculateTotal() {
            updateTotals();
        }
        
        // حذف الطلب
        function deleteOrder(orderId) {
            if (!confirm('هل أنت متأكد من حذف هذا الطلب؟')) {
                return;
            }
            
            fetch('{{ url('/pos/delete') }}/' + orderId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم حذف الطلب بنجاح');
                    loadRecentOrders(); // إعادة تحميل القائمة
                } else {
                    alert('حدث خطأ: ' + (data.message || 'فشل الحذف'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ في حذف الطلب');
            });
        }
        
        // طباعة الطلب
        function printOrder(orderId) {
            window.open('{{ url('/pos/print') }}/' + orderId, '_blank');
        }
        
        // فتح نافذة الدليفري
        function openDeliveryModal() {
            $('#deliveryModal').modal('show');
        }
    </script>
    
    <!-- Modal الطلبات السابقة -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="recentOrdersModal" 
        style="width: 80%; max-width: 1200px;">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title">
                <i class="fas fa-history me-2"></i>الطلبات الأخيرة (10 طلبات)
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0" style="font-size: 0.9rem;">
                    <thead class="table-dark sticky-top">
                        <tr class="text-center">
                            <th style="width: 5%;">#</th>
                            <th style="width: 12%;">رقم الفاتورة</th>
                            <th style="width: 15%;">التاريخ</th>
                            <th style="width: 18%;">العميل</th>
                            <th style="width: 12%;">النوع</th>
                            <th style="width: 13%;">الإجمالي</th>
                            <th style="width: 10%;">الحالة</th>
                            <th style="width: 15%;">العمليات</th>
                        </tr>
                    </thead>
                    <tbody id="recentOrdersList">
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">جاري التحميل...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal الدفع -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 900px;">
            <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                <!-- Header -->
                <div class="modal-header text-white py-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <h5 class="modal-title fw-bold mb-0">
                        <i class="fas fa-cash-register me-2"></i>الدفع والإجماليات
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-3">
                    <div class="row g-2">
                        <!-- العمود الأيمن -->
                        <div class="col-md-6">
                            <!-- الإجمالي -->
                            <div class="mb-2 p-2 rounded" style="background: #f8f9fa; border-right: 4px solid #667eea;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-calculator text-primary me-1"></i>
                                        <span class="fw-bold" style="font-size: 0.9rem;">الإجمالي</span>
                                    </div>
                                    <h5 class="mb-0 text-primary" id="payment_total" style="font-size: 1.1rem;">10.00 ج.م</h5>
                                </div>
                            </div>

                            <!-- الخصم -->
                            <div class="mb-2 p-2 rounded" style="background: #e3f2fd; border-right: 4px solid #2196f3;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <i class="fas fa-percent text-info me-1"></i>
                                        <span class="fw-bold" style="font-size: 0.9rem;">الخصم</span>
                                    </div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-7">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white px-2">
                                                <i class="fas fa-tag text-info"></i>
                                            </span>
                                            <input type="number" class="form-control form-control-sm" id="discount_value" 
                                                placeholder="قيمة" step="0.01" value="0" style="font-size: 0.85rem;">
                                            <span class="input-group-text bg-primary text-white px-2" style="font-size: 0.75rem;">ج.م</span>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control form-control-sm" id="discount_percent" 
                                                placeholder="0" step="0.01" value="0" style="font-size: 0.85rem;">
                                            <span class="input-group-text bg-white px-2" style="font-size: 0.75rem;">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- الصافي -->
                            <div class="mb-2 p-2 rounded" style="background: #e8f5e9; border-right: 4px solid #4caf50;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        <span class="fw-bold" style="font-size: 0.9rem;">الصافي</span>
                                    </div>
                                    <h5 class="mb-0 text-success" id="payment_net" style="font-size: 1.1rem;">10.00 ج.م</h5>
                                </div>
                            </div>
                        </div>

                        <!-- العمود الأيسر -->
                        <div class="col-md-6">
                            <!-- المدفوع -->
                            <div class="mb-2 p-2 rounded" style="background: #ffebee; border-right: 4px solid #f44336;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <i class="fas fa-wallet text-danger me-1"></i>
                                        <span class="fw-bold" style="font-size: 0.9rem;">المدفوع</span>
                                    </div>
                                    <div class="badge bg-danger" style="font-size: 0.85rem; padding: 4px 10px;">0.00 ج.م</div>
                                </div>
                                <input type="number" class="form-control form-control-sm text-center fw-bold" 
                                    id="paid_amount" step="0.01" placeholder="0.00" value="0"
                                    style="border: 2px solid #f44336; font-size: 1rem;">
                            </div>

                            <!-- بيانات الآجل -->
                            <div class="p-2 rounded" style="background: #fff3e0; border-right: 4px solid #ff9800;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <i class="fas fa-clock text-warning me-1"></i>
                                        <span class="fw-bold" style="font-size: 0.9rem;">بيانات الآجل</span>
                                    </div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-12 mb-1">
                                        <input type="text" class="form-control form-control-sm" id="later_name" 
                                            placeholder="اسم الشخص..." style="font-size: 0.85rem;">
                                    </div>
                                    <div class="col-12 mb-1">
                                        <input type="text" class="form-control form-control-sm" id="later_notes" 
                                            placeholder="ملاحظات..." style="font-size: 0.85rem;">
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white px-2" style="font-size: 0.75rem;">قيمة الآجل</span>
                                            <input type="number" class="form-control form-control-sm text-danger fw-bold text-center" 
                                                id="later_amount" step="0.01" placeholder="0.00" value="0.00" readonly
                                                style="font-size: 0.9rem;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 p-2" style="background: #f8f9fa;">
                    <button type="button" class="btn btn-sm px-3" data-bs-dismiss="modal"
                        style="background: #6c757d; color: white; border-radius: 8px;">
                        <i class="fas fa-times me-1"></i>إلغاء
                    </button>
                    <button type="button" class="btn btn-success btn-sm px-3" onclick="saveOrderOnly()"
                        style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none; border-radius: 8px;">
                        <i class="fas fa-save me-1"></i>حفظ الطلب
                    </button>
                    <button type="button" class="btn btn-primary btn-sm px-3" onclick="saveAndPrint()"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px;">
                        <i class="fas fa-print me-1"></i>حفظ وطباعة
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal الطاولات -->
    <div class="modal fade" id="tablesModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-chair me-2"></i>اختر الطاولة
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3" id="tablesGrid">
                        @php
                            $tables = DB::table('tables')->where('isdeleted', 0)->get();
                        @endphp
                        @foreach($tables as $table)
                            <div class="col-md-3">
                                <div class="card table-card {{ $table->table_case == 0 ? 'border-success' : 'border-danger' }}" 
                                    style="cursor: pointer;" 
                                    onclick="selectTable({{ $table->id }}, '{{ $table->tname }}', {{ $table->table_case }})">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chair fa-3x mb-2 {{ $table->table_case == 0 ? 'text-success' : 'text-danger' }}"></i>
                                        <h5>{{ $table->tname }}</h5>
                                        <span class="badge {{ $table->table_case == 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $table->table_case == 0 ? 'متاحة' : 'محجوزة' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal إغلاق الشيفت -->
    <div class="modal fade" id="closeShiftModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-power-off me-2"></i>إغلاق الشيفت
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="shiftPreview" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">جاري تحميل البيانات...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-warning" onclick="closeShift()">
                        <i class="fas fa-power-off me-1"></i>إغلاق الشيفت
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal الدليفري -->
    <div class="modal fade" id="deliveryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-motorcycle me-2"></i>بيانات العميل - دليفري
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- رقم العميل -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">رقم العميل</label>
                        <input type="text" class="form-control form-control-lg" id="delivery_customer_phone" 
                            placeholder="أدخل رقم الموبايل" maxlength="11"
                            style="border: 2px solid #17a2b8; font-size: 1.1rem; text-align: center;">
                        <small class="text-muted d-block mt-1">سيتم البحث تلقائياً بعد كتابة 3 أرقام</small>
                    </div>

                    <!-- نتيجة البحث -->
                    <div id="delivery_customer_result" class="mb-3"></div>

                    <!-- رقم الموبايل -->
                    <div class="mb-3">
                        <label class="form-label">رقم الموبايل</label>
                        <input type="text" class="form-control" id="delivery_customer_mobile" 
                            placeholder="رقم الموبايل" readonly
                            style="background-color: #f8f9fa;">
                    </div>

                    <!-- اسم العميل -->
                    <div class="mb-3">
                        <label class="form-label">اسم العميل</label>
                        <input type="text" class="form-control" id="delivery_customer_name" 
                            placeholder="اسم العميل">
                    </div>

                    <!-- العنوان -->
                    <div class="mb-3">
                        <label class="form-label">العنوان</label>
                        <textarea class="form-control" id="delivery_customer_address" rows="2" 
                            placeholder="عنوان العميل"></textarea>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" id="delivery_customer_id" value="0">
                    <input type="hidden" id="delivery_customer_found" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>إلغاء
                    </button>
                    <button type="button" class="btn btn-warning" id="btnEditCustomer" style="display: none;">
                        <i class="fas fa-edit me-1"></i>حفظ التعديل
                    </button>
                    <button type="button" class="btn btn-success" id="btnConfirmDelivery" onclick="confirmDelivery()">
                        <i class="fas fa-check me-1"></i>تأكيد الطلب
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // اختيار طاولة
        function selectTable(tableId, tableName, tableCase) {
            if (tableCase == 1) {
                if (!confirm('هذه الطاولة محجوزة. هل تريد المتابعة؟')) {
                    return;
                }
            }
            
            $('#selected_table_id').val(tableId);
            $('#selected_table_name').val(tableName);
            $('#selected_table_display').text(tableName);
            $('#selectedTableDisplay').show();
            $('#selectedTableName').text(tableName);
            
            // تحديد نوع الطلب كطاولة
            $('#age2').prop('checked', true);
            
            $('#tablesModal').modal('hide');
        }
        
        // حفظ الطلب فقط
        function saveOrderOnly() {
            const items = document.querySelectorAll('#itemData .item-card-order');
            console.log('Save order clicked, items:', items.length);
            
            if (items.length === 0) {
                alert('يرجى إضافة أصناف للطلب');
                return;
            }
            
            // إغلاق المودال
            $('#paymentModal').modal('hide');
            
            // إرسال النموذج
            console.log('Submitting form...');
            document.getElementById('posForm').submit();
        }
        
        // حفظ وطباعة
        function saveAndPrint() {
            const items = document.querySelectorAll('#itemData .item-card-order');
            console.log('Save and print clicked, items:', items.length);
            
            if (items.length === 0) {
                alert('يرجى إضافة أصناف للطلب');
                return;
            }
            
            // إضافة حقل مخفي للطباعة
            let printInput = document.getElementById('print_after_save');
            if (!printInput) {
                printInput = document.createElement('input');
                printInput.type = 'hidden';
                printInput.name = 'print_after_save';
                printInput.id = 'print_after_save';
                printInput.value = '1';
                document.getElementById('posForm').appendChild(printInput);
            } else {
                printInput.value = '1';
            }
            
            // إغلاق المودال
            $('#paymentModal').modal('hide');
            
            // إرسال النموذج
            console.log('Submitting form with print flag...');
            document.getElementById('posForm').submit();
        }
        
        // دالة قديمة للتوافق
        function completePayment() {
            saveOrderOnly();
        }
        
        // البحث عن عميل برقم الموبايل
        let searchTimeout;
        $('#delivery_customer_phone').on('input', function() {
            const phone = $(this).val().trim();
            
            // مسح timeout السابق
            clearTimeout(searchTimeout);
            
            // إخفاء النتيجة السابقة
            $('#delivery_customer_result').html('');
            
            if (phone.length < 3) {
                return;
            }
            
            // عرض مؤشر التحميل
            $('#delivery_customer_result').html(`
                <div class="alert alert-info text-center py-2">
                    <i class="fas fa-spinner fa-spin me-2"></i>جاري البحث...
                </div>
            `);
            
            // البحث بعد 500ms من آخر كتابة
            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: '{{ route("pos.search-customer") }}',
                    method: 'POST',
                    data: {
                        phone: phone,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success && response.found) {
                            // عميل موجود
                            const customer = response.customer;
                            
                            $('#delivery_customer_result').html(`
                                <div class="alert alert-success py-2 mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>تم العثور على العميل</strong>
                                </div>
                            `);
                            
                            // ملء البيانات
                            $('#delivery_customer_id').val(customer.id);
                            $('#delivery_customer_mobile').val(customer.phone);
                            $('#delivery_customer_name').val(customer.name);
                            $('#delivery_customer_address').val(customer.address);
                            $('#delivery_customer_found').val('1');
                            
                            // جعل الحقول قابلة للتعديل
                            $('#delivery_customer_name').prop('readonly', false);
                            $('#delivery_customer_address').prop('readonly', false);
                            
                            // إظهار زر التعديل
                            $('#btnEditCustomer').show();
                            $('#btnConfirmDelivery').text('تأكيد الطلب');
                            
                        } else if (response.success && !response.found) {
                            // عميل جديد
                            $('#delivery_customer_result').html(`
                                <div class="alert alert-info py-2 mb-0">
                                    <i class="fas fa-user-plus me-2"></i>
                                    <strong>عميل جديد - يرجى إدخال بياناته</strong>
                                </div>
                            `);
                            
                            // مسح البيانات
                            $('#delivery_customer_id').val('0');
                            $('#delivery_customer_mobile').val(phone);
                            $('#delivery_customer_name').val('').prop('readonly', false);
                            $('#delivery_customer_address').val('').prop('readonly', false);
                            $('#delivery_customer_found').val('0');
                            
                            // إخفاء زر التعديل
                            $('#btnEditCustomer').hide();
                            $('#btnConfirmDelivery').text('تأكيد الطلب');
                        }
                    },
                    error: function() {
                        $('#delivery_customer_result').html(`
                            <div class="alert alert-danger py-2 mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                حدث خطأ في البحث
                            </div>
                        `);
                    }
                });
            }, 500);
        });
        
        // حفظ تعديل بيانات العميل
        $('#btnEditCustomer').on('click', function() {
            const customerId = $('#delivery_customer_id').val();
            const name = $('#delivery_customer_name').val().trim();
            const address = $('#delivery_customer_address').val().trim();
            
            if (!name || !address) {
                alert('يرجى ملء الاسم والعنوان');
                return;
            }
            
            if (!confirm('هل تريد حفظ التعديلات على بيانات العميل؟')) {
                return;
            }
            
            // يمكن إضافة AJAX request لحفظ التعديلات في قاعدة البيانات
            $.ajax({
                url: '/customers/update/' + customerId,
                method: 'POST',
                data: {
                    name: name,
                    address: address,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('تم حفظ التعديلات بنجاح');
                },
                error: function() {
                    alert('حدث خطأ في حفظ التعديلات');
                }
            });
        });
        
        // تأكيد الدليفري
        function confirmDelivery() {
            const phone = $('#delivery_customer_phone').val().trim();
            const mobile = $('#delivery_customer_mobile').val().trim();
            const name = $('#delivery_customer_name').val().trim();
            const address = $('#delivery_customer_address').val().trim();
            const customerId = parseInt($('#delivery_customer_id').val()) || 0;
            
            console.log('Confirm Delivery:', {
                phone: phone,
                mobile: mobile,
                name: name,
                address: address,
                customerId: customerId,
                isNew: customerId === 0
            });
            
            if (!phone || !name || !address) {
                alert('يرجى ملء جميع الحقول المطلوبة');
                return;
            }
            
            // حفظ البيانات في حقول مخفية في النموذج الرئيسي
            let deliveryDataInput = $('#delivery_data');
            if (deliveryDataInput.length === 0) {
                deliveryDataInput = $('<input type="hidden" id="delivery_data" name="delivery_data">');
                $('#posForm').append(deliveryDataInput);
            }
            
            const deliveryData = {
                customer_id: customerId,
                phone: mobile || phone,
                name: name,
                address: address
            };
            
            console.log('Delivery data to send:', deliveryData);
            deliveryDataInput.val(JSON.stringify(deliveryData));
            
            // تحديث العميل في select box - فقط إذا كان موجود
            if (customerId > 0) {
                $('select[name="acc2_id"]').val(customerId);
                console.log('Updated acc2_id to:', customerId);
            } else {
                console.log('New customer - will be created on save');
            }
            
            $('#deliveryModal').modal('hide');
            
            // عرض رسالة نجاح
            const message = customerId > 0 
                ? 'تم تأكيد بيانات العميل: ' + name 
                : 'سيتم إضافة عميل جديد: ' + name;
            
            // عرض badge بجانب زر الدليفري
            $('#delivery_confirmed_badge').remove();
            $('#age3').next('label').append(`
                <span class="badge bg-success ms-1" id="delivery_confirmed_badge">
                    <i class="fas fa-check"></i> ${name}
                </span>
            `);
            
            alert(message);
        }
        
        // فتح modal الدليفري
        function openDeliveryModal() {
            // مسح البيانات السابقة
            $('#delivery_customer_phone').val('');
            $('#delivery_customer_mobile').val('');
            $('#delivery_customer_name').val('').prop('readonly', false);
            $('#delivery_customer_address').val('').prop('readonly', false);
            $('#delivery_customer_id').val('0');
            $('#delivery_customer_found').val('0');
            $('#delivery_customer_result').html('');
            $('#btnEditCustomer').hide();
            
            $('#deliveryModal').modal('show');
        }
        
        // إغلاق الشيفت
        function closeShift() {
            if (confirm('هل أنت متأكد من إغلاق الشيفت؟')) {
                window.location.href = '{{ route("pos.close-shift.get") }}';
            }
        }
        
        // تحديث قيم الدفع عند فتح المودال
        $('#paymentModal').on('show.bs.modal', function() {
            const total = parseFloat($('#total').val()) || 0;
            const net = parseFloat($('#net_val').val()) || 0;
            
            $('#payment_total').text(total.toFixed(2) + ' ج.م');
            $('#payment_net').text(net.toFixed(2) + ' ج.م');
            $('#paid_amount').val(0);
            $('#discount_value').val(0);
            $('#discount_percent').val(0);
            $('#later_amount').val('0.00');
        });
        
        // حساب الخصم بالقيمة
        $('#discount_value').on('input', function() {
            const total = parseFloat($('#total').val()) || 0;
            const discountValue = parseFloat($(this).val()) || 0;
            
            // حساب النسبة المئوية
            const discountPercent = total > 0 ? (discountValue / total * 100) : 0;
            $('#discount_percent').val(discountPercent.toFixed(2));
            
            // حساب الصافي
            const net = total - discountValue;
            $('#payment_net').text(net.toFixed(2) + ' ج.م');
            $('#net_val').val(net.toFixed(2));
            $('#discount').val(discountValue.toFixed(2));
            
            // تحديث الآجل
            updateLaterAmount();
        });
        
        // حساب الخصم بالنسبة المئوية
        $('#discount_percent').on('input', function() {
            const total = parseFloat($('#total').val()) || 0;
            const discountPercent = parseFloat($(this).val()) || 0;
            
            // حساب القيمة
            const discountValue = total * (discountPercent / 100);
            $('#discount_value').val(discountValue.toFixed(2));
            
            // حساب الصافي
            const net = total - discountValue;
            $('#payment_net').text(net.toFixed(2) + ' ج.م');
            $('#net_val').val(net.toFixed(2));
            $('#discount').val(discountValue.toFixed(2));
            
            // تحديث الآجل
            updateLaterAmount();
        });
        
        // تحديث المبلغ المدفوع
        $('#paid_amount').on('input', function() {
            updateLaterAmount();
        });
        
        // دالة تحديث قيمة الآجل
        function updateLaterAmount() {
            const net = parseFloat($('#net_val').val()) || 0;
            const paid = parseFloat($('#paid_amount').val()) || 0;
            const later = net - paid;
            
            $('#later_amount').val(later.toFixed(2));
            
            // تغيير لون الآجل حسب القيمة
            if (later > 0) {
                $('#later_amount').removeClass('text-success').addClass('text-danger');
            } else {
                $('#later_amount').removeClass('text-danger').addClass('text-success');
            }
        }
    </script>
</body>
</html>
