@extends('dashboard.layout')

@section('content')
<!-- Select2 CSS -->
<link href="{{ asset('native/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('native/plugins/select2/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form action="{{ route('journals.store-multi') }}" method="post" id="multiJournalForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col col-3">
                                <h1>قيد يومية متعدد</h1>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="journal_id">رقم دفتري</label>
                                            <input name="journal_id" type="text" class="form-control" value="{{ old('journal_id', $nextId) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="jdate">تاريخ</label>
                                            <input name="jdate" type="date" class="form-control" value="{{ old('jdate', date('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <i class="text-zinc-500">تأكد من توازن القيد و عدم ترك قيم فارغة</i>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-zinc-50">
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

                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-md-3">من</th>
                                                <th class="col-md-8">اسم الحساب</th>
                                                <th class="col-md-1">حذف</th>
                                            </tr>
                                        </thead>
                                        <tbody id="depitBody">
                                            <tr id="depitTr" class="depitTr">
                                                <td>
                                                    <input class="form-control depit" type="number" name="depitval[]" step="0.01" min="0" value="0" required>
                                                </td>
                                                <td>
                                                    <select class="form-control depitacc" name="depitname[]" required>
                                                        <option value="0">اختر حساب</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->aname }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <button type="button" class="btn bg-sky-200" id="addDepit">+ إضافة صف مدين</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-3">الي</th>
                                                <th class="col-8">اسم الحساب</th>
                                                <th class="col-1">حذف</th>
                                            </tr>
                                        </thead>
                                        <tbody id="creditBody">
                                            <tr id="creditTr" class="creditTr">
                                                <td>
                                                    <input class="form-control credit" type="number" name="creditval[]" step="0.01" min="0" value="0" required>
                                                </td>
                                                <td>
                                                    <select class="form-control creditacc" name="creditname[]" style="height:70px !important" required>
                                                        <option value="0">اختر حساب</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->aname }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <button type="button" class="btn bg-sky-200" id="addCredit">+ إضافة صف دائن</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="details">بيان</label>
                                <input type="text" name="details" class="form-control" value="{{ old('details') }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">اجمالي مدين</label>
                                    <input name="total" id="depit2" type="text" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">اجمالي دائن</label>
                                    <input id="credit2" type="text" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">الفرق</label>
                                    <input id="balance" type="text" readonly class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-block" id="confirm">حفظ</button>
                            </div>
                            <div class="col">
                                <button type="reset" class="btn btn-block">مسح</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('journals.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('native/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for account dropdowns
    $('.depitacc, .creditacc').select2();

    // Function to calculate the sum of elements with a specific selector
    function sum(elements) {
        let total = 0;
        elements.each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        return total;
    }

    // Update sums and balance when any input changes
    function updateTotals() {
        let depitSum = sum($(".depit"));
        $("#depit2").val(depitSum.toFixed(2));

        let creditSum = sum($(".credit"));
        $("#credit2").val(creditSum.toFixed(2));

        let balance = creditSum - depitSum;
        $("#balance").val(balance.toFixed(2));

        // Change color based on balance
        if (Math.abs(balance) < 0.01) {
            $("#balance").css('color', 'green');
            $("#depit2, #credit2").css('color', 'green');
        } else {
            $("#balance").css('color', 'red');
            $("#depit2, #credit2").css('color', 'red');
        }

        // Show/hide confirm button
        let depitTotal = parseFloat($("#depit2").val()) || 0;
        let creditTotal = parseFloat($("#credit2").val()) || 0;
        if (Math.abs(balance) < 0.01 && depitTotal > 0 && creditTotal > 0) {
            $("#confirm").show();
        } else {
            $("#confirm").hide();
        }
    }

    // Update totals on input change
    $(document).on("keyup", ".depit, .credit", function() {
        updateTotals();
    });

    // Update totals on select change
    $(document).on("change", ".depitacc, .creditacc", function() {
        updateTotals();
    });

    // Add new row for debit accounts
    $('#addDepit').click(function(e) {
        e.preventDefault();
        let lastDepitTr = $('.depitTr:last');
        let selected = lastDepitTr.find('.depitacc option:selected');
        let depitval = lastDepitTr.find('input.depit').val();

        if (!depitval || parseFloat(depitval) === 0 || selected.val() == 0) {
            alert('الرجاء إدخال قيمة أكبر من الصفر و اختيار الحساب.');
            return;
        }

        // Clone the last row
        let newRow = lastDepitTr.clone();
        newRow.removeClass('depitTr');
        newRow.addClass('depit-row');
        
        // Update the row
        newRow.find('input.depit').val(depitval);
        newRow.find('.depitacc').val(selected.val()).trigger('change');
        newRow.find('td:last').html('<button type="button" class="delete-row btn btn-danger btn-sm">X</button>');

        // Insert before the last depitTr
        lastDepitTr.before(newRow);

        // Reinitialize Select2 for new row
        newRow.find('.depitacc').select2();

        // Clear the last input fields
        lastDepitTr.find('input.depit').val('0');
        lastDepitTr.find('.depitacc').val('0').trigger('change');

        // Recalculate sums
        updateTotals();
    });

    // Add new row for credit accounts
    $('#addCredit').click(function(e) {
        e.preventDefault();
        let lastCreditTr = $('.creditTr:last');
        let selected = lastCreditTr.find('.creditacc option:selected');
        let creditval = lastCreditTr.find('input.credit').val();

        if (!creditval || parseFloat(creditval) === 0 || selected.val() == 0) {
            alert('الرجاء إدخال قيمة أكبر من الصفر و اختيار الحساب.');
            return;
        }

        // Clone the last row
        let newRow = lastCreditTr.clone();
        newRow.removeClass('creditTr');
        newRow.addClass('credit-row');
        
        // Update the row
        newRow.find('input.credit').val(creditval);
        newRow.find('.creditacc').val(selected.val()).trigger('change');
        newRow.find('td:last').html('<button type="button" class="delete-row btn btn-danger btn-sm">X</button>');

        // Insert before the last creditTr
        lastCreditTr.before(newRow);

        // Reinitialize Select2 for new row
        newRow.find('.creditacc').select2();

        // Clear the last input fields
        lastCreditTr.find('input.credit').val('0');
        lastCreditTr.find('.creditacc').val('0').trigger('change');

        // Recalculate sums
        updateTotals();
    });

    // Remove row when the delete button is clicked
    $(document).on('click', '.delete-row', function() {
        $(this).closest('tr').remove();
        updateTotals(); // Recalculate sums after deletion
    });

    // Form validation
    $('#multiJournalForm').on('submit', function(e) {
        let balance = parseFloat($("#balance").val()) || 0;
        let depitTotal = parseFloat($("#depit2").val()) || 0;
        let creditTotal = parseFloat($("#credit2").val()) || 0;

        if (Math.abs(balance) > 0.01) {
            e.preventDefault();
            alert('المدين يجب أن يساوي الدائن! المدين: ' + depitTotal.toFixed(2) + ' | الدائن: ' + creditTotal.toFixed(2));
            return false;
        }

        if (depitTotal === 0 || creditTotal === 0) {
            e.preventDefault();
            alert('يجب إدخال قيم للمدين والدائن');
            return false;
        }
    });

    // Initialize totals
    updateTotals();
    $("#confirm").hide();
});
</script>
@endsection
