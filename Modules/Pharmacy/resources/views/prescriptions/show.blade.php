@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col col-3 h3">{{ $client->name ?? '' }}</div>
                </div>
                <!-- /.row -->
                
                <div class="col col-3 h3">التحاليل المطلوبة</div>
                <br>
                <div class="col h6 bg-slate-100">{{ $prescription->analayses ?? '-' }}</div>
                <br>
                <div class="col col-3 h3">الأدوية المطلوبة</div>
                @if($prescriptionDetails && $prescriptionDetails->count() > 0)
                    @foreach($prescriptionDetails as $detail)
                        <div class="col h6 bg-slate-50">{{ $detail->drug_name }}</div>
                        <div class="col h6 bg-slate-50">{{ $detail->dose }}</div>
                    @endforeach
                @else
                    <div class="col h6 bg-slate-50">لا توجد أدوية</div>
                @endif

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col col-10">
                        <a href="{{ route('prescriptions.print', ['id' => $prescription->id]) }}" target="_blank" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                    <div class="col">
                        @php
                            $whatsappText = '';
                            if($prescriptionDetails && $prescriptionDetails->count() > 0) {
                                foreach($prescriptionDetails as $detail) {
                                    $whatsappText .= $detail->drug_name . "\n" . $detail->dose . "\n";
                                }
                            }
                            $whatsappUrl = 'https://wa.me/2' . ($client->phone ?? '') . '?text=' . urlencode($whatsappText);
                        @endphp
                        <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success">
                            <i class="fa fa-comment" aria-hidden="true"></i> Send WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
