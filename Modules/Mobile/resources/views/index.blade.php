@extends('dashboard.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-mobile-alt mr-2"></i>
                        تصفح المنتجات - الموبايل
                    </h3>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        @foreach($items as $item)
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($item->image)
                                <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                                @endif
                                
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="text-muted mb-2">
                                        <small>كود: {{ $item->code }}</small>
                                    </p>
                                    @if($item->barcode)
                                    <p class="text-muted mb-2">
                                        <small><i class="fas fa-barcode"></i> {{ $item->barcode }}</small>
                                    </p>
                                    @endif
                                    <h4 class="text-success mb-0">
                                        {{ number_format($item->price, 2) }} جنيه
                                        @if($item->unit)
                                        <small class="text-muted">/ {{ $item->unit }}</small>
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($items->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i>
                        لا توجد منتجات حالياً
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

