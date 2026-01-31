@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form action="{{ route('journals.update') }}?id={{ $journal->id }}" method="post" id="journalForm">
                @csrf
                @method('PUT')
                <div class="card card-warning">
                    <div class="card-header">
                        <h1>تعديل قيد يومية</h1>
                    </div>
                    <div class="card-body">
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
                            <div class="col">
                                <div class="form-group">
                                    <label for="journal_id">رقم دفتري</label>
                                    <input name="journal_id" type="text" class="form-control" value="{{ old('journal_id', $journal->journal_id) }}" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="jdate">تاريخ</label>
                                    <input name="jdate" type="date" class="form-control" value="{{ old('jdate', $journal->jdate) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="journalTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>مدين</th>
                                        <th>دائن</th>
                                        <th>اسم الحساب</th>
                                        <th>ملاحظات</th>
                                        <th>حذف</th>
                                    </tr>
                                </thead>
                                <tbody id="journalRows">
                                    @foreach($journal->details as $detail)
                                        <tr class="journal-row">
                                            <td>
                                                <input required class="form-control debit-input" type="number" name="debit[]" step="0.01" min="0" value="{{ $detail->debit }}">
                                            </td>
                                            <td>
                                                <input required class="form-control credit-input" type="number" name="credit[]" step="0.01" min="0" value="{{ $detail->credit }}">
                                            </td>
                                            <td>
                                                <select class="form-control" name="acc_id[]" required>
                                                    <option value="">اختر حساب</option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->id }}" {{ $detail->account_id == $account->id ? 'selected' : '' }}>
                                                            {{ $account->code }} - {{ $account->aname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="info_details[]" class="form-control" value="{{ $detail->info }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><strong id="totalDebit">0.00</strong></td>
                                        <td><strong id="totalCredit">0.00</strong></td>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-primary" id="addRow">إضافة صف</button>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group mt-3">
                            <label for="info">بيان</label>
                            <textarea name="info" id="info" class="form-control" rows="3">{{ old('info', $journal->details) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">تحديث</button>
                        <a href="{{ route('journals.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Add new row
    $('#addRow').click(function() {
        var newRow = $('.journal-row').first().clone();
        newRow.find('input').val('0');
        newRow.find('select').val('');
        $('#journalRows').append(newRow);
        updateTotals();
    });

    // Remove row
    $(document).on('click', '.remove-row', function() {
        if ($('.journal-row').length > 1) {
            $(this).closest('.journal-row').remove();
            updateTotals();
        } else {
            alert('يجب أن يكون هناك صف واحد على الأقل');
        }
    });

    // Update totals
    function updateTotals() {
        var totalDebit = 0;
        var totalCredit = 0;

        $('.debit-input').each(function() {
            totalDebit += parseFloat($(this).val()) || 0;
        });

        $('.credit-input').each(function() {
            totalCredit += parseFloat($(this).val()) || 0;
        });

        $('#totalDebit').text(totalDebit.toFixed(2));
        $('#totalCredit').text(totalCredit.toFixed(2));

        if (Math.abs(totalDebit - totalCredit) > 0.01) {
            $('#totalDebit, #totalCredit').css('color', 'red');
        } else {
            $('#totalDebit, #totalCredit').css('color', 'green');
        }
    }

    $(document).on('input', '.debit-input, .credit-input', function() {
        updateTotals();
    });

    $('#journalForm').on('submit', function(e) {
        var totalDebit = 0;
        var totalCredit = 0;

        $('.debit-input').each(function() {
            totalDebit += parseFloat($(this).val()) || 0;
        });

        $('.credit-input').each(function() {
            totalCredit += parseFloat($(this).val()) || 0;
        });

        if (Math.abs(totalDebit - totalCredit) > 0.01) {
            e.preventDefault();
            alert('المدين يجب أن يساوي الدائن! المدين: ' + totalDebit.toFixed(2) + ' | الدائن: ' + totalCredit.toFixed(2));
            return false;
        }
    });

    updateTotals();
});
</script>
@endsection
