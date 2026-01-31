@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row text-center">
                <div class="container col-md-7">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="cake cake-zoomIn">إدخال كارت جديد</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('bookings.store') }}" method="post">
                                @csrf
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="form-group">
                                    <label class="cake cake-zoomIn">اسم العميل</label>
                                    <input list="customerList" name="cname" id="cname" class="form-control" placeholder="ابحث عن العميل هنا" value="{{ old('cname') }}" required>
                                    <datalist id="customerList">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->name }}">
                                        @endforeach
                                    </datalist>
                                    <small id="cname_status" class="form-text text-muted"></small>
                                </div>

                                <div class="form-group">
                                    <label class="cake cake-zoomIn">كود الحجز</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control" placeholder="" value="{{ old('barcode') }}" required>
                                    <small id="barcode_status" class="form-text text-muted"></small>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="cake cake-zoomIn">نوع الحجز</label>
                                            <select name="rtybe" id="bmethod" class="form-control" required>
                                                <option value="">-- اختر --</option>
                                                @foreach($bookingTypes as $type)
                                                    <option value="{{ $type->id }}" {{ old('rtybe') == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="cake cake-zoomIn">قيمة الحجز</label>
                                            <input type="number" name="rcost" id="rcost" class="form-control" value="{{ old('rcost') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="cake cake-zoomIn">عدد</label>
                                            <input type="number" name="qty" id="qty" class="form-control" value="{{ old('qty') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label class="cake cake-zoomIn">من</label>
                                        <input type="date" name="fromdate" value="{{ old('fromdate', date('Y-m-d')) }}" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <label class="cake cake-zoomIn">إلى</label>
                                        <input type="date" name="todate" value="{{ old('todate') }}" class="form-control" required>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success">حجز</button>
                                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">إلغاء</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // Check client name
    $('#cname').on('blur', function(){
        var cname = $(this).val();
        if(cname != ''){
            $.ajax({
                url: '{{ route("bookings.check-client") }}',
                method: 'POST',
                data: { 
                    cname: cname,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response){
                    $('#cname_status').text(response);
                }
            });
        }
    });

    // Check barcode
    $('#barcode').on('blur', function(){
        var barcode = $(this).val();
        if(barcode != ''){
            $.ajax({
                url: '{{ route("bookings.check-barcode") }}',
                method: 'POST',
                data: { 
                    barcode: barcode,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response){
                    $('#barcode_status').html(response);
                }
            });
        }
    });

    // Get booking type info
    $('#bmethod').on('change', function(){
        var bookingTypeId = $(this).val();
        if (bookingTypeId != '') {
            $.ajax({
                url: '{{ route("bookings.get-type-info") }}',
                method: 'POST',
                data: { 
                    id: bookingTypeId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data){
                    $('#rcost').val(data.value);
                    $('#qty').val(data.qty);
                },
                error: function(xhr, status, error){
                    alert("حدث خطأ في تحميل البيانات");
                }
            });
        } else {
            $('#rcost').val('');
            $('#qty').val('');
        }
    });
});
</script>
@endsection
