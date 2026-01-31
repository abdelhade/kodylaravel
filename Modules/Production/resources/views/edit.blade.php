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
            <div class="card card-warning">
                <div class="card-header">
                    <div class="row">
                        <div class="col"><h2 class="">تعديل إنتاجية</h2></div>
                        <div class="col"><a href="{{ route('production.index') }}" class="float-right">الإنتاجيات</a></div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
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

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteProductionModal">
                        <i class="fa fa-trash"></i> حذف
                    </button>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteProductionModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">حذف الإنتاجية</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>هل أنت متأكد من حذف الإنتاجية؟</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                                    <form action="{{ route('production.destroy', ['snd_id' => $firstProduction->snd_id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('production.update', ['edit' => $firstProduction->snd_id]) }}" method="post" id="productionForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="snd_id" value="{{ $firstProduction->snd_id }}">

                        <div class="table">
                            <div class="row">
                                <div class="form-group">
                                    <label for="date">التاريخ</label>
                                    <input type="date" name="date" class="form-control" required value="{{ old('date', $firstProduction->date) }}">
                                </div>
                                <div class="form-group">
                                    <label for="info">بيان</label>
                                    <input type="text" name="info" class="form-control bg-orange-200" style="width: 300px;" value="{{ old('info', $firstProduction->info) }}">
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
                                    @foreach($productions as $index => $production)
                                        <tr>
                                            <td class="mslsl">{{ $index + 1 }}</td>
                                            <td>
                                                <select name="emp_name[]" class="form-hors" required>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->name }}" {{ $employee->name == $production->emp_name ? 'selected' : '' }}>
                                                            {{ $employee->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-hors qty" pattern="[0-9]*\.?[0-9]+" value="{{ old('qty.'.$index, $production->qty) }}" name="qty[]" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-hors price" pattern="[0-9]*\.?[0-9]+" value="{{ old('price.'.$index, $production->price) }}" name="price[]" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-hors value" pattern="[0-9]*\.?[0-9]+" value="{{ old('val.'.$index, $production->value) }}" name="val[]" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-hors info2" value="{{ old('info2.'.$index, $production->info2) }}" name="info2[]">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger delete-row">-</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col">
                                    <button id="addRow" class="btn btn-primary" type="button">+</button>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn bg-yellow-400 btn-block">تأكيد</button>
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
