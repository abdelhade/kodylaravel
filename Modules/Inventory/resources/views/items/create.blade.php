@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @if(isset($role['add_items']) && $role['add_items'] == 1)
                <div class="card">
                    <form id="myForm" action="{{ route('items.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header bg-blue-400">
                            <div class="col">
                                <h3>صنف جديد</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="code">الكود</label>
                                        <input readonly value="{{ $nextCode }}" class="form-control form-control-sm col-4" type="text" name="code" id="code">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="barcode">الباركود</label>
                                        <input required value="{{ $nextCode }}" class="form-control form-control-sm" type="text" name="barcode" id="barcode">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="iname">اسم الصنف</label>
                                        <datalist id="inamelist">
                                            @foreach($itemNames as $name)
                                                <option value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </datalist>
                                        <input list="inamelist" required class="frst form-control form-control-sm" type="text" name="iname" id="iname" value="{{ old('iname') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name2">اسم ثاني</label>
                                        <input class="form-control form-control-sm" type="text" name="name2" id="name2" value="{{ old('name2') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="info">تفاصيل</label>
                                        <input class="form-control form-control-sm" type="text" name="info" id="info" value="{{ old('info') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-light p-3 mt-3">
                                <b>الوحدات</b>
                                <p id="addUnit" class="btn btn-primary">اضافه وحده</p>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th class="w-80" style="width:120px">الوحدة</th>
                                                    <th class="w-80" style="width:120px">م التحويل</th>
                                                    <th class="w-80" style="width:120px">باركود</th>
                                                    <th class="w-80" style="width:120px">سعر التكلفه</th>
                                                    <th class="w-80" style="width:120px">سعر البيع</th>
                                                    <th class="w-80" style="width:120px">سعر البيع 2</th>
                                                    <th class="w-80" style="width:120px">سعر السوق</th>
                                                    <th class="w-80" style="width:120px">حذف</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="urow">
                                                    <td>
                                                        <select name="unit_id[]" class="form-control">
                                                            @foreach($units as $unit)
                                                                <option value="{{ $unit->id }}">{{ $unit->uname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number" readonly name="u_val[]" value="1" step="0.001">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="unit_barcode[]" value="{{ $nextCode }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="cost_price[]" class="form-control form-control-sm" value="0.00" step="0.001">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="price1[]" class="form-control form-control-sm" value="0.00" step="0.001">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="price2[]" class="form-control form-control-sm" value="0.00" step="0.001">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="market_price[]" class="form-control form-control-sm" value="0.00" step="0.001">
                                                    </td>
                                                    <th>
                                                        <p class="btn btn-danger deleteRow">X</p>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="group1">المجموعة</label>
                                        <select name="group1" id="group1" class="form-control form-control-sm float-right">
                                            <option value="">اختر المجموعة</option>
                                            @foreach($groups1 as $group)
                                                <option value="{{ $group->id }}" {{ old('group1') == $group->id ? 'selected' : '' }}>
                                                    {{ $group->gname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="group2">التصنيف</label>
                                        <select name="group2" id="group2" class="form-control form-control-sm float-right">
                                            <option value="">اختر التصنيف</option>
                                            @foreach($groups2 as $group)
                                                <option value="{{ $group->id }}" {{ old('group2') == $group->id ? 'selected' : '' }}>
                                                    {{ $group->gname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label class="btn btn-secondary" for="img">صور للصنف</label>
                                <input type="file" name="imgs[]" id="img" multiple accept="image/*">
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-lg float-right btn-block">حفظ</button>
                                </div>
                                <div class="col"></div>
                            </div>
                        </div>
                    </form>

                    <div class="card-footer">
                        <p>iname , code , barcode , cost_price , price1 , price2 , qty</p>
                        <div class="col-md-3">
                            <form action="{{ route('items.upload') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <label for="file">تحميل ورقة اكسيل</label>
                                <input type="file" name="file" id="file">
                                <button class="btn btn-secondary" type="submit">تحميل</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    {{ $userErrorMassage ?? 'ليس لديك صلاحية للوصول إلى هذه الصفحة' }}
                </div>
            @endif
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Fields to monitor
    var fields = ["cost_price", "price1", "price2", "market_price"];

    // Monitor first row fields
    fields.forEach(function(fieldName) {
        $('.urow:first input[name="' + fieldName + '[]"]').on('input', function() {
            updateAllRows(fieldName);
        });
    });

    // Monitor u_val changes
    $(document).on('input', 'input[name="u_val[]"]', function() {
        var currentRow = $(this).closest('.urow');
        var u_val = parseFloat($(this).val()) || 1;
        
        fields.forEach(function(fieldName) {
            var firstRowValue = parseFloat($('.urow:first input[name="' + fieldName + '[]"]').val()) || 0;
            currentRow.find('input[name="' + fieldName + '[]"]').val((firstRowValue * u_val).toFixed(3));
        });
    });

    // Update all rows based on first row
    function updateAllRows(fieldName) {
        $('.urow').each(function(index) {
            if (index === 0) return;
            
            var currentRow = $(this);
            var u_val_current = parseFloat(currentRow.find('input[name="u_val[]"]').val()) || 1;
            var firstRowValue = parseFloat($('.urow:first input[name="' + fieldName + '[]"]').val()) || 0;
            currentRow.find('input[name="' + fieldName + '[]"]').val((firstRowValue * u_val_current).toFixed(3));
        });
    }

    // Add new unit row
    $('#addUnit').click(function() {
        var clone = $('.urow').first().clone();
        clone.find('input[name="u_val[]"]').val('1').prop('readonly', false);
        clone.find('input[name="unit_barcode[]"]').val('');
        
        var u_val_main = parseFloat($('.urow').first().find('input[name="u_val[]"]').val()) || 1;
        
        fields.forEach(function(fieldName) {
            var firstValue = parseFloat($('.urow').first().find('input[name="' + fieldName + '[]"]').val()) || 0;
            clone.find('input[name="' + fieldName + '[]"]').val((firstValue * u_val_main).toFixed(3));
        });
        
        $('.urow').last().after(clone);
        
        clone.find('.deleteRow').click(function() {
            if ($('.urow').length > 1) clone.remove();
            else alert('لا يمكن حذف الوحدة الاولي');
        });
    });

    // Delete row
    $('.deleteRow').click(function() {
        if ($('.urow').length > 1) $(this).closest('.urow').remove();
        else alert('لا يمكن حذف الوحدة الاولي');
    });

    // Prevent duplicate units
    $("form").on("submit", function(e) {
        let selectedValues = [];
        let duplicateFound = false;

        $('select[name="unit_id[]"]').each(function() {
            let selectedValue = $(this).val();
            if (selectedValues.includes(selectedValue)) {
                duplicateFound = true;
            }
            selectedValues.push(selectedValue);
        });

        if (duplicateFound) {
            e.preventDefault();
            alert("غير مسموح بتكرار الوحدات");
        }
    });

    // Prevent Enter key submission
    $(document).on('keydown', function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    });
});
</script>
@endsection
