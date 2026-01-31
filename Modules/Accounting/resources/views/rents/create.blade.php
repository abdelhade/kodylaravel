@extends('dashboard.layout')

@section('content')
<style>
.msg-success {
    position: fixed;
    bottom: 50px;
    left: 50px;
    z-index: 90;
    opacity: 1;
    transition: opacity 2s ease-in-out;
}
.hide {
    opacity: 0;
}
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @if(session('success'))
                <h4 id="successMessage" class='bg-success hadi-alert hazaz'>تم تسجيل عقد الإيجار بنجاح</h4>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form autocomplete="off" action="{{ route('rents.store') }}" method="post" enctype="multipart/form-data" class='validate_form' autocomplete="off" id="myForm">
                <div class="card {{ $rent ? 'card-warning' : 'card-primary' }}">
                    <div class="card-header">
                        <div class="row">
                            <div class="col hazaz"><h2>عقد إيجار</h2></div>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="cl_id">اسم المستأجر</label>
                                <span class="text-danger text-lg">*</span>
                            </div>
                            <div class="col-lg-3">
                                <select name="cl_id" id="cl_id" class="form-control frst" required>
                                    <option value="">اختر المستأجر</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('cl_id', $rent->cl_id ?? '') == $client->id ? 'selected' : '' }}>
                                            {{ $client->aname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="rent_id">العين المستأجرة</label>
                                <span class="text-danger text-lg">*</span>
                            </div>
                            <div class="col-lg-3">
                                <select name="rent_id" id="rent_id" class="form-control frst" required {{ $rentId ? 'disabled' : '' }}>
                                    <option value="">اختر العين</option>
                                    @foreach($rentableUnits as $unit)
                                        <option value="{{ $unit->id }}" {{ old('rent_id', $rentId ?? '') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->aname }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($rentId)
                                    <input type="hidden" name="rent_id" value="{{ $rentId }}">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="phone">تليفون المستأجر</label>
                            </div>
                            <div class="col-lg-3">
                                <input type="text" name="phone" id="phone" class="form-control" data-parsley-trigger="keyup" required minlength="6" value="{{ old('phone', $rent->phone ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="idintity">رقم الهوية</label>
                            </div>
                            <div class="col-lg-3">
                                <input type="text" name="idintity" id="idintity" class="form-control" required value="{{ old('idintity', $rent->idintity ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="start_date">مدة الإيجار</label>
                            </div>
                            <div class="col-lg-2">
                                <input type="date" name="start_date" id="start_date" class="form-control" required value="{{ old('start_date', $rent->start_date ?? '') }}">
                            </div>
                            <div class="col-lg-2">
                                <input type="date" name="end_date" id="end_date" class="form-control" required value="{{ old('end_date', $rent->end_date ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="pay_tybe">استحقاق الإيجار</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="radio-group bg-light text-lg">
                                    <label><input type="radio" name="pay_tybe" value="0" {{ old('pay_tybe', $rent->pay_tybe ?? '1') == '0' ? 'checked' : '' }}> يومي</label>
                                    <label><input type="radio" name="pay_tybe" value="1" {{ old('pay_tybe', $rent->pay_tybe ?? '1') == '1' ? 'checked' : '' }}> شهري</label>
                                    <label><input type="radio" name="pay_tybe" value="2" {{ old('pay_tybe', $rent->pay_tybe ?? '1') == '2' ? 'checked' : '' }}> ربع سنوي</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="r_value">قيمة الإيجار</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="number" name="r_value" id="r_value" class="form-control" required value="{{ old('r_value', $rent->r_value ?? '') }}" step="0.01" min="0.01">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="bnd1">بند 1 <span><input type="checkbox" name="" id="bnd1_check" data-toggle="collapse" data-target="#bnd1"></span></label>
                            </div>
                            <div id="bnd1" class="col-md-12 collapse">
                                <input type="text" name="bnd1" id="bnd1_input" class="form-control" value="{{ old('bnd1', $rent->bnd1 ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="bnd2">بند 2 <span><input type="checkbox" name="" id="bnd2_check" data-toggle="collapse" data-target="#bnd2"></span></label>
                            </div>
                            <div id="bnd2" class="col-md-12 collapse">
                                <input type="text" name="bnd2" id="bnd2_input" class="form-control" value="{{ old('bnd2', $rent->bnd2 ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="bnd3">بند 3 <span><input type="checkbox" name="" id="bnd3_check" data-toggle="collapse" data-target="#bnd3"></span></label>
                            </div>
                            <div id="bnd3" class="col-md-12 collapse">
                                <input type="text" name="bnd3" id="bnd3_input" class="form-control" value="{{ old('bnd3', $rent->bnd3 ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2" style="font-size:20px;">
                                <label for="bnd4">بند 4 <span><input type="checkbox" name="" id="bnd4_check" data-toggle="collapse" data-target="#bnd4"></span></label>
                            </div>
                            <div id="bnd4" class="col-md-12 collapse">
                                <input type="text" name="bnd4" id="bnd4_input" class="form-control" value="{{ old('bnd4', $rent->bnd4 ?? '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="subBtn">حفظ (f12)</button>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
// Hide success message after 2 seconds
document.addEventListener('DOMContentLoaded', function() {
    var successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(function() {
            successMessage.classList.add('hide');
        }, 2000);
    }
});

// Validate rent value > 0
$(document).ready(function() {
    $('#subBtn').on('click', function() {
        var r_value = $("#r_value").val();
        if (r_value === "0" || r_value === "0.00" || parseFloat(r_value) <= 0) {
            alert("يجب أن تكون قيمة الإيجار أكبر من صفر");
            $("#r_value").focus();
            return false;
        }
    });
});

// F12 shortcut
$(document).keydown(function(e) {
    if (e.keyCode === 123) { // F12
        e.preventDefault();
        $('#subBtn').click();
    }
});
</script>
@endsection
