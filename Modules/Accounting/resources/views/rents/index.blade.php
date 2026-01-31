@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-light">
                <div class="card-header">
                    <h2>تقرير الوحدات الإيجارية</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($rentables as $rentable)
                            <div class="small-box col-lg-2 {{ $rentable->rentable == 1 ? 'bg-info' : 'bg-warning' }}" style="margin:10px;">
                                <div class="inner">
                                    <h5>{{ $rentable->aname }}</h5>
                                    @if($rentable->rentable == 2 && isset($rentable->rent_details))
                                        <p>{{ $rentable->client->aname ?? '' }}</p>
                                        <p>{{ $rentable->rent_details->phone ?? '' }}</p>
                                        <p>{{ $rentable->rent_details->start_date }} إلى {{ $rentable->rent_details->end_date }}</p>
                                        <p>قيمة الإيجار = {{ $rentable->rent_details->r_value }}</p>
                                        <p>
                                            <a class='btn btn-light btn-sm' href="{{ route('rents.destroy', ['id' => $rentable->rent_details->id, 'r' => $rentable->id]) }}" 
                                               onclick="return confirm('هل تريد بالتأكيد إخلاء الوحدة وحذف العقد ومسح الأقساط المتبقية؟')">
                                                إخلاء الوحدة
                                            </a>
                                        </p>
                                    @endif
                                    <p>{{ $rentable->info ?? '' }}</p>
                                </div>
                                <a href="{{ $rentable->rentable == 1 ? route('rents.create') : route('rents.create', ['id' => $rentable->id]) }}">
                                    <div class="icon">
                                        <i class="fa fa-store"></i>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
