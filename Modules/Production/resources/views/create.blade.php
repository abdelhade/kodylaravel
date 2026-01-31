@extends('dashboard.layout')

@section('content')
<style>
    .form-hors {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 5px;
        margin: 0px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h2>إضافة إنتاجية</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('production.store') }}" method="post" id="productionForm">
                        @csrf
                        <input type="hidden" name="snd_id" value="{{ $nextId }}">

                        <div class="table">
                            <div class="row">
                                <div class="form-group">
                                    <label for="date">التاريخ</label>
                                    <input type="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label for="info">بيان</label>
                                    <input type="text" name="info" class="form-control bg-orange-200" style="width: 300px;" value="{{ old('info') }}">
                                </div>
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>اسم الموظف</th>
                                        <th>الوحدات المنتجة</th>
                                        <th>السعر</th>
                                        <th>القيمة</th>
                                        <th>ملاحظات</th>
                                        <th>حذف</th>
                                    </tr>
                                </thead>
                                <tbody id="empRow">
                                    <tr>
                                        <td class="mslsl">1</td>
                                        <td>
                                            <select autofocus name="emp_name[]" class="form-hors" required>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->name }}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-hors qty" pattern="[0-9]*\.?[0-9]+" value="1" name="qty[]" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-hors price" pattern="[0-9]*\.?[0-9]+" value="1" name="price[]" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-hors value" pattern="[0-9]*\.?[0-9]+" value="1" name="val[]" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-hors info2" value="" name="info2[]">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger delete-row">-</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col">
                                    <button id="addRow" class="btn btn-primary" type="button">+</button>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn bg-sky-200 btn-block">تأكيد</button>
                                </div>
                                <div class="col"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Add row
    $('#addRow').click(function() {
        var $table = $('#empRow');
        var $firstRow = $table.find('tr:first');
        var $mslsl = $table.find('.mslsl:last');
        var $newRow = $firstRow.clone();
        $newRow.find('input').val('1');
        $newRow.find('.mslsl').html(Number($mslsl.html()) + 1);
        $table.append($newRow);
    });

    // Calculate value
    $('#empRow').on('input', '.qty, .price', function() {
        var $row = $(this).closest('tr');
        var qty = parseFloat($row.find('.qty').val()) || 0;
        var price = parseFloat($row.find('.price').val()) || 0;
        var value = qty * price;
        $row.find('.value').val(value.toFixed(2));
    });

    // Delete row
    $('#empRow').on('click', '.delete-row', function() {
        var $row = $(this).closest('tr');
        if ($('#empRow tr').length > 1) {
            $row.remove();
            // Update row numbers
            $('#empRow tr').each(function(index) {
                $(this).find('.mslsl').html(index + 1);
            });
        }
    });
});
</script>
@endsection
