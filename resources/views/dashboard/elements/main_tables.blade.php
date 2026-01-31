<div class="dashboard-widgets">
    <div class="row g-4">
        <!-- آخر حسابات تم إنشاءها -->
        <div class="col-xl-4 col-lg-6">
            <div class="modern-card card-accounts">
                <div class="card-header">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-chart-line header-icon"></i>
                        </div>
                        <div class="header-text">
                            <h4>آخر حسابات تم إنشاءها</h4>
                            <p class="card-subtitle">أحدث 5 حسابات مضافة</p>
                        </div>
                    </div>
                    <div class="header-badge">
                        <span>5</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="modern-table">
                            <div class="table-header">
                                <div class="table-row header-row">
                                    <div class="table-cell">#</div>
                                    <div class="table-cell">اسم الحساب</div>
                                    <div class="table-cell">الرصيد</div>
                                    <div class="table-cell">يتبع ل</div>
                                </div>
                            </div>
                            <div class="table-body">
                                @if(isset($recentAccounts) && count($recentAccounts) > 0)
                                    @foreach($recentAccounts as $index => $account)
                                    <div class="table-row">
                                        <div class="table-cell">
                                            <span class="serial-number">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="table-cell">
                                            <div class="account-info">
                                                <div class="main-text">{{ $account->aname ?? '' }}</div>
                                                <div class="sub-text">{{ $account->code ?? '' }}</div>
                                            </div>
                                        </div>
                                        <div class="table-cell">
                                            <div class="amount-display {{ ($account->balance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                                                {{ number_format($account->balance ?? 0, 2) }}
                                            </div>
                                        </div>
                                        <div class="table-cell">
                                            <span class="parent-name">{{ $account->parent_name ?? '-' }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="table-row">
                                        <div class="table-cell" colspan="4" style="text-align: center; padding: 20px;">
                                            لا توجد حسابات حديثة
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="view-all-btn">
                        <span>عرض جميع الحسابات</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- محلل العمل اليومي -->
        <div class="col-xl-4 col-lg-6">
            <div class="modern-card card-operations">
                <div class="card-header">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-chart-bar header-icon"></i>
                        </div>
                        <div class="header-text">
                            <h4>محلل العمل اليومي</h4>
                            <p class="card-subtitle">أحدث 5 عمليات</p>
                        </div>
                    </div>
                    <div class="header-badge">
                        <span>5</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="modern-table">
                            <div class="table-header">
                                <div class="table-row header-row">
                                    <div class="table-cell">#</div>
                                    <div class="table-cell">التاريخ</div>
                                    <div class="table-cell">العملية</div>
                                    <div class="table-cell">القيمة</div>
                                </div>
                            </div>
                            <div class="table-body">
                                @if(isset($recentOperations) && count($recentOperations) > 0)
                                    @foreach($recentOperations as $index => $operation)
                                    <div class="table-row">
                                        <div class="table-cell">
                                            <span class="serial-number">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="table-cell">
                                            <div class="date-display">{{ $operation->pro_date ?? '' }}</div>
                                        </div>
                                        <div class="table-cell">
                                            <span class="operation-badge">{{ $operation->type_name ?? '-' }}</span>
                                        </div>
                                        <div class="table-cell">
                                            <div class="amount-display positive">
                                                {{ number_format($operation->pro_value ?? 0, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="table-row">
                                        <div class="table-cell" colspan="4" style="text-align: center; padding: 20px;">
                                            لا توجد عمليات حديثة
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="view-all-btn">
                        <span>عرض جميع العمليات</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- آخر أصناف تم إنشاءها -->
        <div class="col-xl-4 col-lg-6">
            <div class="modern-card card-items">
                <div class="card-header">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-boxes header-icon"></i>
                        </div>
                        <div class="header-text">
                            <h4>آخر أصناف تم إنشاءها</h4>
                            <p class="card-subtitle">أحدث 5 أصناف مضافة</p>
                        </div>
                    </div>
                    <div class="header-badge">
                        <span>5</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="modern-table">
                            <div class="table-header">
                                <div class="table-row header-row">
                                    <div class="table-cell">#</div>
                                    <div class="table-cell">اسم الصنف</div>
                                    <div class="table-cell">الرصيد</div>
                                </div>
                            </div>
                            <div class="table-body">
                                @if(isset($recentItems) && count($recentItems) > 0)
                                    @foreach($recentItems as $index => $item)
                                    <div class="table-row">
                                        <div class="table-cell">
                                            <span class="serial-number">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="table-cell">
                                            <div class="item-info">
                                                <div class="main-text">{{ $item->iname ?? '' }}</div>
                                                <div class="sub-text">رقم: {{ $item->id ?? '' }}</div>
                                            </div>
                                        </div>
                                        <div class="table-cell">
                                            <div class="stock-indicator {{ ($item->itmqty ?? 0) > 0 ? 'in-stock' : 'out-of-stock' }}">
                                                <span class="stock-value">{{ $item->itmqty ?? 0 }}</span>
                                                <span class="stock-label">وحدة</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="table-row">
                                        <div class="table-cell" colspan="3" style="text-align: center; padding: 20px;">
                                            لا توجد أصناف حديثة
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="view-all-btn">
                        <span>عرض جميع الأصناف</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- آخر 5 زيارات -->
        <div class="col-xl-4 col-lg-6">
            <div class="modern-card card-sessions">
                <div class="card-header">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-sign-in-alt header-icon"></i>
                        </div>
                        <div class="header-text">
                            <h4>آخر 5 زيارات</h4>
                            <p class="card-subtitle">أحدث تسجيلات الدخول</p>
                        </div>
                    </div>
                    <div class="header-badge">
                        <span>5</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="sessions-list">
                        @if(isset($recentSessions) && count($recentSessions) > 0)
                            @foreach($recentSessions as $session)
                            <div class="session-item">
                                <div class="session-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="session-info">
                                    <div class="session-user">{{ $session->user_name ?? '__' }}</div>
                                    <div class="session-time">{{ $session->crtime ?? '' }}</div>
                                </div>
                                <div class="session-status active"></div>
                            </div>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 20px;">
                                لا توجد زيارات حديثة
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- المبيعات -->
        <div class="col-xl-4 col-lg-6">
            <div class="modern-card card-sales">
                <div class="card-header">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-chart-pie header-icon"></i>
                        </div>
                        <div class="header-text">
                            <h4>المبيعات</h4>
                            <p class="card-subtitle">إحصائيات المبيعات</p>
                        </div>
                    </div>
                    <div class="header-badge trend-up">
                        <i class="fas fa-trending-up"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="sales-stats">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ number_format($salesStats['last_invoice'] ?? 0, 2) }}</div>
                                <div class="stat-label">آخر فاتورة</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ number_format($salesStats['last_week'] ?? 0, 2) }}</div>
                                <div class="stat-label">آخر أسبوع</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ number_format($salesStats['last_month'] ?? 0, 2) }}</div>
                                <div class="stat-label">آخر 30 يوم</div>
                            </div>
                        </div>
                        <div class="stat-card highlight">
                            <div class="stat-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ number_format($salesStats['total'] ?? 0, 2) }}</div>
                                <div class="stat-label">إجمالي المبيعات</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الزيارات الأخيرة -->
        <div class="col-xl-4 col-lg-6">
            <div class="modern-card card-reservations">
                <div class="card-header">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-calendar-alt header-icon"></i>
                        </div>
                        <div class="header-text">
                            <h4>الزيارات الأخيرة</h4>
                            <p class="card-subtitle">أحدث 5 زيارات</p>
                        </div>
                    </div>
                    <div class="header-badge">
                        <span>5</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="visits-list">
                        @if(isset($recentReservations) && count($recentReservations) > 0)
                            @foreach($recentReservations as $reservation)
                            <div class="visit-item">
                                <div class="visit-avatar">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                                <div class="visit-info">
                                    <div class="visit-client">{{ $reservation->client_name ?? '__' }}</div>
                                    <div class="visit-details">
                                        <span class="visit-date">{{ $reservation->date ?? '' }}</span>
                                        <span class="visit-time">{{ $reservation->time ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 20px;">
                                لا توجد زيارات حديثة
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- الأقساط المستحقة -->
        <div class="col-xl-8 col-lg-12">
            <div class="modern-card card-installments">
                <div class="card-header">
                    <div class="header-content">
                        <div class="icon-wrapper">
                            <i class="fas fa-money-bill-wave header-icon"></i>
                        </div>
                        <div class="header-text">
                            <h4>الاقساط المستحقة</h4>
                            <p class="card-subtitle">الأقساط التي تجاوزت تاريخ الاستحقاق</p>
                        </div>
                    </div>
                    <div class="header-badge warning">
                        <span>مستحق</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="modern-table">
                            <div class="table-header">
                                <div class="table-row header-row">
                                    <div class="table-cell">#</div>
                                    <div class="table-cell">الوحدة</div>
                                    <div class="table-cell">العميل</div>
                                    <div class="table-cell">تاريخ الاستحقاق</div>
                                    <div class="table-cell">المستحق</div>
                                    <div class="table-cell">المدفوع</div>
                                    <div class="table-cell">الحالة</div>
                                </div>
                            </div>
                            <div class="table-body">
                                @if(isset($dueInstallments) && count($dueInstallments) > 0)
                                    @foreach($dueInstallments as $index => $installment)
                                    <div class="table-row">
                                        <div class="table-cell">
                                            <span class="serial-number">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="table-cell">
                                            <span class="unit-name">{{ $installment->rent_name ?? '-' }}</span>
                                        </div>
                                        <div class="table-cell">
                                            <span class="client-name">{{ $installment->client_name ?? '-' }}</span>
                                        </div>
                                        <div class="table-cell">
                                            <div class="date-display overdue">{{ $installment->ins_date ?? '' }}</div>
                                        </div>
                                        <div class="table-cell">
                                            <div class="amount-display due">{{ number_format($installment->ins_value ?? 0, 2) }}</div>
                                        </div>
                                        <div class="table-cell">
                                            <div class="amount-display paid">{{ number_format($installment->ins_paid ?? 0, 2) }}</div>
                                        </div>
                                        <div class="table-cell">
                                            <span class="status-tag status-{{ $installment->ins_case ?? 0 }}">
                                                @if(($installment->ins_case ?? 0) == 2)
                                                    مستحق
                                                @elseif(($installment->ins_case ?? 0) == 3)
                                                    مدفوع
                                                @else
                                                    ___
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="table-row">
                                        <div class="table-cell" colspan="7" style="text-align: center; padding: 20px;">
                                            لا توجد أقساط مستحقة
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="view-all-btn">
                        <span>عرض جميع الأقساط</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
