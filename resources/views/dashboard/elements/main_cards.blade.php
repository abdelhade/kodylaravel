<div class="dashboard-cards">
    <div class="row g-4">
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stat-card bg-gradient-primary">
                <div class="card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="card-content">
                    <h2 class="stat-number">{{ $stats['due_installments'] ?? 0 }}</h2>
                    <p class="stat-label">الاقساط المستحقة</p>
                </div>
                <div class="card-footer-det">
                    <a href="#" class="card-link">
                        <span>عرض التفاصيل</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </div>
                <div class="wave-effect"></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stat-card bg-gradient-info">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-content">
                    <h2 class="stat-number">{{ $stats['clients'] ?? 0 }}</h2>
                    <p class="stat-label">العملاء</p>
                </div>
                <div class="card-footer-det">
                    <a href="#" class="card-link">
                        <span>عرض التفاصيل</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </div>
                <div class="wave-effect"></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stat-card bg-gradient-success">
                <div class="card-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <div class="card-content">
                    <h2 class="stat-number">{{ $stats['sessions'] ?? 0 }}</h2>
                    <p class="stat-label">مرات الدخول</p>
                </div>
                <div class="card-footer-det">
                    <a href="#" class="card-link">
                        <span>عرض التفاصيل</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </div>
                <div class="wave-effect"></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stat-card bg-gradient-warning">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-content">
                    <h2 class="stat-number">
                        {{ $stats['sales_count'] ?? 0 }} / {{ number_format(($stats['sales_total'] ?? 0) / 1000, 2, '.', '') }}K
                    </h2>
                    <p class="stat-label">المبيعات</p>
                </div>
                <div class="card-footer-det">
                    <a href="#" class="card-link">
                        <span>عرض التفاصيل</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </div>
                <div class="wave-effect"></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stat-card bg-gradient-secondary">
                <div class="card-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-content">
                    <h2 class="stat-number">{{ $stats['tasks'] ?? 0 }}</h2>
                    <p class="stat-label">إجمالي الطلبات</p>
                </div>
                <div class="card-footer-det">
                    <a href="#" class="card-link">
                        <span>عرض التفاصيل</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </div>
                <div class="wave-effect"></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stat-card bg-gradient-dark">
                <div class="card-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="card-content">
                    <h2 class="stat-number">{{ $stats['pending_tasks'] ?? 0 }}</h2>
                    <p class="stat-label">المهمات المعلقة</p>
                </div>
                <div class="card-footer-det">
                    <a href="#" class="card-link">
                        <span>عرض التفاصيل</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </div>
                <div class="wave-effect"></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="stat-card bg-gradient-danger">
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-content">
                    <h2 class="stat-number">{{ $stats['reservations'] ?? 0 }}</h2>
                    <p class="stat-label">الزيارات المعلقة</p>
                </div>
                <div class="card-footer-det">
                    <a href="#" class="card-link">
                        <span>عرض التفاصيل</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </div>
                <div class="wave-effect"></div>
            </div>
        </div>
    </div>
</div>
