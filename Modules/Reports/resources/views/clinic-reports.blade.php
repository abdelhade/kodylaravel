@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h2>تقارير العيادات</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <a href="{{ asset('native/print/pre_clients.php') }}" target="_blank" class="btn btn-primary">
                                بيانات المرضى
                            </a>
                        </div>
                        <div class="col">
                            <span>تقرير اليومية</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
