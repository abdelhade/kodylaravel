@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form action="{{ route('journals.store') }}" method="post" id="journalForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col col-3">
                                <h1>قيد يومية
                                    @if($type == 1)
                                        شراء أصل
                                    @elseif($type == 2)
                                        بيع أصل
                                    @else
                                        عام
                                    @endif
                                </h1>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="journal_id">رقم دفتري</label>
                                            <input name="journal_id" type="text" class="form-control" value="{{ old('journal_id', $nextId) }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="jdate">تاريخ</label>
                                            <input name="jdate" type="date" class="form-control" value="{{ old('jdate', date('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                        <div class="table-responsive">
                            <table id="journalTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-1">مدين</th>
                                        <th class="col-1">دائن</th>
                                        <th class="col-4">اسم الحساب</th>
                                        <th class="col-4">ملاحظات</th>
                                        <th class="col-1">حذف</th>
                                    </tr>
                                </thead>
                                <tbody id="journalRows">
                                    <tr class="journal-row">
                                        <td>
                                            <input required class="form-control debit-input" type="number" name="debit[]" step="0.01" min="0" value="0">
                                        </td>
                                        <td>
                                            <input required class="form-control credit-input" type="number" name="credit[]" step="0.01" min="0" value="0">
                                        </td>
                                        <td>
                                            <select class="form-control" name="acc_id[]" required>
                                                <option value="">اختر حساب</option>
                                                @php
                                                    if($type == 1) {
                                                        $accounts = DB::table('acc_head')->where('is_basic', 0)->where('code', 'like', '11%')->get();
                                                    } elseif($type == 2) {
                                                        $accounts = DB::table('acc_head')->where('is_basic', 0)->where('code', 'not like', '11%')->get();
                                                    } else {
                                                        $accounts = DB::table('acc_head')->where('is_basic', 0)->get();
                                                    }
                                                @endphp
                                                @foreach($accounts as $account)
                                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->aname }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="info_details[]" class="form-control">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                                        </td>
                                    </tr>
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
                            <textarea name="info" id="info" class="form-control" rows="3">{{ old('info') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
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

        // Check if debit = credit
        if (Math.abs(totalDebit - totalCredit) > 0.01) {
            $('#totalDebit, #totalCredit').css('color', 'red');
        } else {
            $('#totalDebit, #totalCredit').css('color', 'green');
        }
    }

    // Listen to input changes
    $(document).on('input', '.debit-input, .credit-input', function() {
        updateTotals();
    });

    // Form validation
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
