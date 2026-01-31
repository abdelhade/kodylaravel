<style>
    /* Sidebar - Fixed Standard Design */
    .sidebar-container {
        width: 250px !important; /* Standard AdminLTE width */
        background-color: #ffffff !important;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        transition: width 0.3s ease;
        overflow-y: auto; 
        overflow-x: hidden !important;
        height: 100vh; /* Full height */
        position: fixed; /* Fix to left */
        top: 0;
        right: 0; /* RTL support */
        z-index: 1038;
        padding-top: 57px; /* Space for navbar */
    }
    
    /* Adjust content wrapper to respect fixed sidebar */
    body:not(.sidebar-collapse) .content-wrapper,
    body:not(.sidebar-collapse) .main-footer,
    body:not(.sidebar-collapse) .main-header {
        margin-right: 250px !important;
        margin-left: 0 !important;
        transition: margin-right 0.3s ease;
    }

    body.sidebar-collapse .content-wrapper,
    body.sidebar-collapse .main-footer,
    body.sidebar-collapse .main-header {
        margin-right: 80px !important; /* Collapsed width */
        margin-left: 0 !important;
    }

    .sidebar-container > div {
        overflow-x: hidden !important;
        width: 100%;
    }
    
    /* Nav Items */
    .sidebar-container .nav-item {
        margin: 0.15rem 0.5rem !important;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .sidebar-container .nav-item:hover {
        background-color: #f8f9fa;
    }
    
    /* Nav Links */
    .sidebar-container .nav-link {
        display: flex !important;
        align-items: center !important;
        padding: 0.7rem 1rem !important;
        color: #4a5568 !important;
        text-decoration: none;
        width: 100%;
    }
    
    /* Icons */
    .sidebar-container .nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        min-width: 30px;
        margin-left: 10px; /* Space between icon and text in RTL */
        border-radius: 6px;
        color: white !important;
        font-size: 0.9rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    /* Text Visibility - ALWAYS VISIBLE */
    .sidebar-container .nav-link p {
        opacity: 1 !important;
        max-width: none !important;
        white-space: normal;
        margin: 0;
        font-size: 0.95rem;
        font-weight: 500;
        color: #2d3748;
        display: inline-block;
    }
    
    /* Different Colors for Each Section - Retained */
    .sidebar-container .nav-item:nth-child(1) .nav-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .sidebar-container .nav-item:nth-child(2) .nav-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .sidebar-container .nav-item:nth-child(3) .nav-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .sidebar-container .nav-item:nth-child(4) .nav-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .sidebar-container .nav-item:nth-child(5) .nav-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
    .sidebar-container .nav-item:nth-child(6) .nav-icon { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); }
    .sidebar-container .nav-item:nth-child(7) .nav-icon { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }
    .sidebar-container .nav-item:nth-child(8) .nav-icon { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); }
    .sidebar-container .nav-item:nth-child(9) .nav-icon { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }

    /* Active State */
    .sidebar-container .nav-link.active {
        background-color: #f0f4ff;
        color: #2563eb !important;
    }
    
    .sidebar-container .nav-link.active .nav-icon {
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }

    /* Submenu (Treeview) */
    .sidebar-container .nav-treeview {
        padding-right: 20px; /* Indent submenu */
        background: transparent;
    }
    .sidebar-container .nav-treeview .nav-icon {
        width: 24px;
        height: 24px;
        font-size: 0.8rem;
    }
    
    /* User Panel */
    .sidebar-container .user-panel {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 1rem;
    }
    
    .sidebar-container .user-panel .info {
        opacity: 1 !important;
        max-width: none !important;
    }
    
    /* Search */
    .sidebar-container .search-wrapper {
        opacity: 1 !important;
        max-height: 50px !important;
        padding: 0.5rem;
    }
    
    /* FIX: Submenu Visibility */
    .sidebar-container .collapse.show {
        display: block !important;
    }
    .sidebar-container .collapsing {
         display: block !important;
         height: auto;
         transition: height 0.35s ease;
    }
</style>

<aside class="sidebar-container">
    <div class="p-3" style="height: 100%; overflow-y: auto; overflow-x: hidden; width: 100%; box-sizing: border-box;">
        <!-- User Panel -->
        <div class="user-panel mb-4">
            <div class="d-flex align-items-center mb-2">
                <div class="image-user me-2">
                    <img src="{{ asset('native/assets/logo/hors.png') }}" alt="User Image"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="user-icon-fallback">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="info flex-grow-1" style="opacity: 0; max-width: 0; overflow: hidden; white-space: nowrap; transition: opacity 0.3s ease, max-width 0.3s ease;">
                    <a href="" class="d-block " style="margin-bottom: 0; text-decoration: none; font-size: 0.85rem;">
                        اهلا يا {{ session('login') }}
                    </a>
                </div>
            </div>
            <div class="search-wrapper" style="position: relative; opacity: 0; max-height: 0; overflow: hidden; transition: opacity 0.3s ease, max-height 0.3s ease;">
                <i class="fas fa-search" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.75rem; pointer-events: none; z-index: 1;"></i>
                <input class="form-control form-control-sm" type="text" placeholder="ابحث..." id="searchSide"
                    style="padding-right: 30px; padding-left: 8px; background-color: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: white; font-size: 0.75rem; height: 28px;">
            </div>
        </div>
        
        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                <!-- الرئيسية -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ $lang['lang_sidemain'] ?? 'الرئيسية' }}</p>
                    </a>
                </li>

                <!-- البيانات الاساسية -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'basic-data')">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            البيانات الاساسية
                            <i class="fas fa-angle-left right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="basic-data" style="display: none; background-color: rgba(255,255,255,0.05);">
                        <li class="nav-item">
                            <a href="{{ route('accounts.index', ['acc' => 'clients']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-users"></i>
                                <p>العملاء</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index', ['acc' => 'suppliers']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>الموردين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index', ['acc' => 'funds']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>الصناديق</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index', ['acc' => 'banks']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-university"></i>
                                <p>البنوك</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index', ['acc' => 'stores']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>المخازن</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index', ['acc' => 'expenses']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-money-bill-wave"></i>
                                <p>المصروفات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index', ['acc' => 'revenues']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>الايرادات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index', ['acc' => 'employees']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>{{ $lang['lang_sideemployees'] ?? 'الموظفين' }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('towns.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-map-marker-alt"></i>
                                <p>المدن</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- المخازن -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'inventory-menu')">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>
                            المخازن
                            <i class="fas fa-angle-left right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="inventory-menu" style="display: none; background-color: rgba(255,255,255,0.05);">
                        <li class="nav-item">
                            <a href="{{ route('items.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>الاصناف</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('items.create') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-plus-circle"></i>
                                <p>صنف جديد</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('acc-report.index', ['acc' => 'stores']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-store"></i>
                                <p>المخازن</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('units.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-ruler"></i>
                                <p>الوحدات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('groups.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>المجموعات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>التصنيفات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barcode_search') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-barcode"></i>
                                <p>عرض سعر الصنف</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('items-start-balance.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-balance-scale"></i>
                                <p>ضبط الارصدة الافتتاحية</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- المشتريات -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'purchases-menu')">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            المشتريات
                            <i class="fas fa-angle-left right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="purchases-menu" style="display: none; background-color: rgba(255,255,255,0.05);">
                        <li class="nav-item">
                            <a href="{{ route('sales.index', ['q' => 'sale']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>فاتورة مشتريات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.index', ['q' => 'resale']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-undo"></i>
                                <p>فاتورة مردود مشتريات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.index', ['q' => 'po']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>أمر شراء</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pos_po') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-barcode"></i>
                                <p>أمر شراء باركود</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- المبيعات -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'sales-menu')">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            المبيعات
                            <i class="fas fa-angle-left right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="sales-menu" style="display: none; background-color: rgba(255,255,255,0.05);">
                        <li class="nav-item">
                            <a href="{{ route('sales.index', ['q' => 'buy']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>فاتورة مبيعات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.index', ['q' => 'rebuy']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-undo"></i>
                                <p>أمر بيع</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.index', ['q' => 'offer']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>عرض سعر للعميل</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ادارة الكاشير -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'pos-menu')">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            ادارة الكاشير
                            <i class="fas fa-angle-left right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="pos-menu" style="display: none; background-color: rgba(255,255,255,0.05);">
                        <li class="nav-item">
                            <a href="{{ route('pos.barcode') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-barcode"></i>
                                <p>نقطة بيع باركود</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pos.barcode-basic') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-cash-register"></i>
                                <p>نقطة بيع بسيطة</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pos.tables.view') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-utensils"></i>
                                <p>نقطة بيع الطاولات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pos.time') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>نقطة بيع الوقت</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pos.tables') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-table"></i>
                                <p>ادارة الطاولات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pos.sessions') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-history"></i>
                                <p>الشيفتات المنتهية</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ادارة الموبايل -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'mobile-menu')">
                        <i class="nav-icon fas fa-mobile-alt"></i>
                        <p>
                            ادارة الموبايل
                            <i class="fas fa-angle-left right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="mobile-menu" style="display: none; background-color: rgba(255,255,255,0.05);">
                        <li class="nav-item">
                            <a href="#" class="nav-link -50">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>قريباً...</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ادارة الحسابات -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'accounts-menu')">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            ادارة الحسابات
                            <i class="fas fa-angle-left right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="accounts-menu" style="display: none; background-color: rgba(255,255,255,0.05);">
                        <li class="nav-item">
                            <a href="{{ route('accounts.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-sitemap"></i>
                                <p>شجرة الحسابات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('acc-report.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-list"></i>
                                <p>قائمة الحسابات مع الارصدة</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '122']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>إضافة عميل</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '211']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>إضافة مورد</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '121']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>إضافة صندوق</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '124']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-university"></i>
                                <p>إضافة بنك</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '44']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-arrow-down"></i>
                                <p>إضافة مصروف</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '32']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-arrow-up"></i>
                                <p>إضافة إيراد</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '212']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>إضافة دائن آخر</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '125']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-hand-holding"></i>
                                <p>إضافة مدين آخر</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '221']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-users"></i>
                                <p>إضافة شريك</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '11']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-building"></i>
                                <p>إضافة أصل</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '213']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>إضافة موظف</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '112']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-key"></i>
                                <p>إضافة أصل قابل للتأجير</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.create', ['parent_id' => '123']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>إضافة مخزون</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('journals.create') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>انشاء قيد يومية</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('journals.create-multi') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>انشاء قيد متعدد</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('journals.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>القيود اليوميه</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vouchers.create', ['t' => 'recive']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>سند القبض</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vouchers.create', ['t' => 'payment']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-money-check"></i>
                                <p>سند دفع</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vouchers.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>السندات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('start-balance.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-balance-scale"></i>
                                <p>الرصيد الافتتاحي للحسابات</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- التقارير -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event, 'reports-menu')">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            {{ $lang['lang_sidereports'] ?? 'التقارير' }}
                            <i class="fas fa-angle-left right ms-auto"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" id="reports-menu" style="display: none; background-color: rgba(255,255,255,0.05);">
                        <li class="nav-item">
                            <a href="{{ route('reports.summary') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>كشف حساب</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales-reports.index') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>تقارير المبيعات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('operations_summary', ['q' => 'sale']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>فواتير المشتريات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('items_summery') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-box"></i>
                                <p>المبيعات اصناف</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reps_cl') }}" class="nav-link -50">
                                <i class="nav-icon fas fa-hospital"></i>
                                <p>تقارير العيادات</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.index', ['t' => 'rents']) }}" class="nav-link -50">
                                <i class="nav-icon fas fa-building"></i>
                                <p>تقارير التأجير</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>


<script>
    function toggleSubmenu(e, id) {
        e.preventDefault();
        var submenu = document.getElementById(id);
        var link = e.currentTarget;
        
        // Close other submenus (optional, mimicking accordion behavior if desired, or keep independent)
        // keeping independent for now as per previous behavior
        
        if (submenu.style.display === 'none' || submenu.style.display === '') {
            submenu.style.display = 'block';
            link.classList.add('active');
            // Rotate arrow if exists
            var arrow = link.querySelector('.right');
            if(arrow) arrow.style.transform = 'rotate(-90deg)';
        } else {
            submenu.style.display = 'none';
            link.classList.remove('active');
            var arrow = link.querySelector('.right');
            if(arrow) arrow.style.transform = 'rotate(0deg)';
        }
    }
</script>
