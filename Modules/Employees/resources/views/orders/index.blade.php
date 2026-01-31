@extends('dashboard.layout')

@section('content')
<style>
    .fa-flag, .fa-calendar-day, .fa-briefcase-medical, .fa-business-time, .fa-clipboard, .fa-pen {
        font-size: 70px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <!-- First Row -->
            <div class="row mt-5">
                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('orders.create', ['id' => 1]) }}">
                        <div class="card text-dark bg-light w mb-3 me-0" style="max-width: 25rem; height: 12rem;">
                            <div class="card-body">
                                <i class="nav-icon fas fa-flag"></i>
                                <h4 class="card-text mt-5">{{ $lang['lang__regularleve_request'] ?? 'طلب إجازة عادية' }}</h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('orders.create', ['id' => 2]) }}">
                        <div class="card text-dark bg-light mb-3" style="max-width: 30rem; height: 12rem;">
                            <div class="card-body">
                                <i class="nav-icon fas fa-calendar-day"></i>
                                <h4 class="card-text mt-5">{{ $lang['lang_annualleave_request'] ?? 'طلب إجازة سنوية' }}</h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('orders.create', ['id' => 3]) }}">
                        <div class="card text-dark bg-light mb-3" style="max-width: 30rem; height: 12rem;">
                            <div class="card-body">
                                <i class="nav-icon fa-light fas fa-briefcase-medical"></i>
                                <h4 class="card-text mt-5">{{ $lang['lang_Sickleave_request'] ?? 'طلب إجازة مرضية' }}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Second Row -->
            <div class="row mt-4">
                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('orders.create', ['id' => 4]) }}">
                        <div class="card text-dark bg-light mb-3" style="max-width: 30rem; height: 12rem;">
                            <div class="card-body">
                                <i class="nav-icon fas fa-business-time"></i>
                                <h4 class="card-text mt-5">{{ $lang['lang_Sickleave_request'] ?? 'طلب إجازة' }}</h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('orders.create', ['id' => 5]) }}">
                        <div class="card text-dark bg-light mb-3" style="max-width: 30rem; height: 12rem;">
                            <div class="card-body">
                                <i class="nav-icon fas fa-pen"></i>
                                <h4 class="card-text mt-5">{{ $lang['lang_Earlydeparture_request'] ?? 'طلب انصراف مبكر' }}</h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('orders.create', ['id' => 6]) }}">
                        <div class="card text-dark bg-light mb-3" style="max-width: 30rem; height: 12rem;">
                            <div class="card-body">
                                <i class="nav-icon fas fa-clipboard"></i>
                                <h4 class="card-text mt-5">{{ $lang['lang_all_orders'] ?? 'جميع الطلبات' }}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
