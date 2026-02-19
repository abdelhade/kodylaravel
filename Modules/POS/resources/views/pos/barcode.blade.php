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
                                    <input type="radio" class="btn-check" id="age1" name="age" value="1" checked>
                                    <label class="btn btn-outline-primary btn-sm" for="age1">
                                        <i class="fas fa-shopping-bag me-1"></i>تيك أواي
                                    </label>

                                    <input type="radio" class="btn-check" id="age2" name="age" value="2" 
                                        {{ request('table') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary btn-sm" for="age2">
                                        <i class="fas fa-chair me-1"></i>طاولة
                                    </label>

                                    <input type="radio" class="btn-check" id="age3" name="age" value="3">
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
                                                    ->where('fd.pro_id', $editOrder->id)
                                                    ->where('fd.isdeleted', 0)
                                                    ->select('fd.*', 'm.iname as item_name', 'm.barcode')
                                                    ->get();
                                                $x = 0;
                                            @endphp
                                            @foreach($details as $detail)
                                                @php
                                                    $x++;
                                                    $item_name = $detail->item_name ?: 'صنف غير معروف';
                                                    $qty = floatval($detail->qty_out) - floatval($detail->qty_in);
                                                    $price = floatval($detail->price);
                                                    $subtotal = floatval($detail->det_value);
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
                            // تفاصيل الأصناف
                            let itemsHtml = '';
                            if (order.items && order.items.length > 0) {
                                itemsHtml = order.items.map(item => 
                                    `${item.item_name} (${item.quantity})`
                                ).join(', ');
                            }
                            
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${order.id}</td>
                                    <td>${order.pro_date}</td>
                                    <td>${new Date(order.crtime).toLocaleTimeString('ar-EG', {hour: '2-digit', minute: '2-digit'})}</td>
                                    <td>${order.items_count || 0}</td>
                                    <td>${parseFloat(order.fat_total).toFixed(2)}</td>
                                    <td>${parseFloat(order.fat_net).toFixed(2)}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editOrder(${order.id})" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteOrder(${order.id})" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="printOrder(${order.id})" title="طباعة">
                                            <i class="fas fa-print"></i>
                                        </button>
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
                <i class="fas fa-history me-2"></i>الطلبات الأخيرة
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0">
                    <thead class="table-dark sticky-top">
                        <tr>
                            <th>#</th>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>النوع</th>
                            <th>الإجمالي</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-money-bill-wave me-2"></i>إتمام الدفع
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-muted">الإجمالي</h6>
                                    <h3 class="text-primary" id="payment_total">0.00 ج.م</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-muted">الصافي</h6>
                                    <h3 class="text-success" id="payment_net">0.00 ج.م</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">طريقة الدفع</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="payment_method" id="cash" value="cash" checked>
                            <label class="btn btn-outline-success" for="cash">
                                <i class="fas fa-money-bill-wave me-1"></i>نقدي
                            </label>
                            
                            <input type="radio" class="btn-check" name="payment_method" id="card" value="card">
                            <label class="btn btn-outline-primary" for="card">
                                <i class="fas fa-credit-card me-1"></i>بطاقة
                            </label>
                            
                            <input type="radio" class="btn-check" name="payment_method" id="later" value="later">
                            <label class="btn btn-outline-warning" for="later">
                                <i class="fas fa-clock me-1"></i>آجل
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">المبلغ المدفوع</label>
                        <input type="number" class="form-control form-control-lg text-center" 
                            id="paid_amount" step="0.01" placeholder="0.00">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">الباقي</label>
                        <input type="text" class="form-control form-control-lg text-center bg-light" 
                            id="change_amount" readonly value="0.00 ج.م">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success btn-lg" onclick="completePayment()">
                        <i class="fas fa-check me-1"></i>إتمام الدفع وطباعة
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
                        <i class="fas fa-motorcycle me-2"></i>بيانات الدليفري
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">رقم الموبايل</label>
                        <input type="text" class="form-control" id="customer_phone" 
                            placeholder="أدخل رقم العميل">
                    </div>
                    <div id="customer_result"></div>
                    <div class="mb-3">
                        <label class="form-label">اسم العميل</label>
                        <input type="text" class="form-control" id="customer_name" 
                            placeholder="اسم العميل">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">العنوان</label>
                        <textarea class="form-control" id="customer_address" rows="2" 
                            placeholder="عنوان التوصيل"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-info" onclick="confirmDelivery()">
                        <i class="fas fa-check me-1"></i>تأكيد
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
        
        // إتمام الدفع
        function completePayment() {
            const items = document.querySelectorAll('#itemData .item-card-order');
            console.log('Complete payment clicked, items:', items.length);
            
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
        
        // تأكيد الدليفري
        function confirmDelivery() {
            const phone = $('#customer_phone').val().trim();
            const name = $('#customer_name').val().trim();
            const address = $('#customer_address').val().trim();
            
            if (!phone || !name || !address) {
                alert('يرجى ملء جميع الحقول');
                return;
            }
            
            $('#deliveryModal').modal('hide');
            alert('تم تأكيد طلب الدليفري');
        }
        
        // إغلاق الشيفت
        function closeShift() {
            if (confirm('هل أنت متأكد من إغلاق الشيفت؟')) {
                window.location.href = '{{ route("pos.close-shift.get") }}';
            }
        }
        
        // تحديث المبلغ المدفوع والباقي
        $('#paid_amount').on('input', function() {
            const total = parseFloat($('#net_val').val()) || 0;
            const paid = parseFloat($(this).val()) || 0;
            const change = paid - total;
            
            $('#change_amount').val(change.toFixed(2) + ' ج.م');
        });
        
        // تحديث قيم الدفع عند فتح المودال
        $('#paymentModal').on('show.bs.modal', function() {
            const total = $('#total').val();
            const net = $('#net_val').val();
            
            $('#payment_total').text(parseFloat(total).toFixed(2) + ' ج.م');
            $('#payment_net').text(parseFloat(net).toFixed(2) + ' ج.م');
            $('#paid_amount').val(net);
            $('#paid_amount').trigger('input');
        });
    </script>
</body>
</html>
