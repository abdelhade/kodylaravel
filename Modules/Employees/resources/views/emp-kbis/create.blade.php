@extends('dashboard.layout')

@section('content')
<style>
    input {
        margin: 0px;
        padding: 0px;
        border: 0px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left">
                        إضافة معدلات التقييم {{ $employeeName ? "[ نسخ : $employeeName ]" : '' }}
                    </h2>
                </div>
                <div class="card-body">
                    <form onsubmit="return validateTotalKBI()" action="{{ route('emp-kbis.store') }}" method="POST">
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

                        <button class="btn btn-lg btn-block bg-green-600 text-slate-50 float-right col-sm-2" type="submit">حفظ</button>

                        <div class="form-group">
                            <label for="emp_id">اسم الموظف</label>
                            <select name="emp_id" class="form-control col-lg-4" required>
                                <option value="">اختر موظف</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ old('emp_id', $employeeId) == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->name }} -- {{
                                            $emp->jop ? (DB::table('jops')->where('id', $emp->jop)->value('name') ?? '') : ''
                                        }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <br>

                        <div id="kbiContainer">
                            @if(isset($employeeId) && count($selectedKbis ?? []) > 0)
                                @foreach($selectedKbis as $kbiId)
                                    @php
                                        $kbi = DB::table('kbis')->where('id', $kbiId)->first();
                                        $weight = DB::table('emp_kbis')->where('emp_id', $employeeId)->where('kbi_id', $kbiId)->value('kbi_weight') ?? 0;
                                    @endphp
                                    @if($kbi)
                                        <div class="row kbi_div">
                                            <select name="kbi_id[]" class="form-control col-lg-4" required>
                                                @foreach($kbis as $k)
                                                    <option value="{{ $k->id }}" {{ $k->id == $kbiId ? 'selected' : '' }} title="{{ $k->info ?? '' }}">
                                                        {{ $k->kname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="kbi_weight[]" class="form-control col-lg-2 weight" placeholder="الوزن" value="{{ $weight }}" required>
                                            <button type="button" class="btn btn-danger delete-kbi">Delete</button>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="row kbi_div">
                                    <select name="kbi_id[]" class="form-control col-lg-4" required>
                                        @foreach($kbis as $kbi)
                                            <option value="{{ $kbi->id }}" title="{{ $kbi->info ?? '' }}">
                                                {{ $kbi->kname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="kbi_weight[]" class="form-control col-lg-2 weight" placeholder="الوزن" value="0.00" required>
                                    <button type="button" class="btn btn-danger delete-kbi" disabled>Delete</button>
                                </div>
                            @endif
                        </div>

                        <button class="btn bg-sky-300" id="addkbi" type="button">+</button>

                        <br>
                        <label for="total_kbi">المجموع الكلي</label>
                        <input type="text" name="total_kbi" id="total_kbi" class="form-control col-lg-2" placeholder="" value="0.00" required readonly>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Add KBI row
    $("#addkbi").click(function(e) {
        e.preventDefault();
        var kbi_div = $(".kbi_div:last");
        var new_kbi_div = kbi_div.clone();
        new_kbi_div.find('input.weight').val('0.00');
        new_kbi_div.find('.delete-kbi').prop('disabled', false);
        kbi_div.after(new_kbi_div);
        updateTotalWeight();
    });

    // Delete KBI row
    $(document).on('click', '.delete-kbi', function() {
        if ($('.kbi_div').length > 1) {
            $(this).closest('.kbi_div').remove();
            updateTotalWeight();
        }
    });

    // Update total weight
    function updateTotalWeight() {
        var total = 0;
        $('input[name="kbi_weight[]"]').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('#total_kbi').val(total.toFixed(2));
    }

    updateTotalWeight();
    $(document).on('input', 'input[name="kbi_weight[]"]', updateTotalWeight);
});

function validateTotalKBI() {
    var totalKBI = parseFloat(document.getElementById('total_kbi').value);
    if (Math.abs(totalKBI - 100) > 0.01) {
        alert('المجموع الكلي يجب أن يساوي 100');
        return false;
    }
    return true;
}
</script>
@endsection
