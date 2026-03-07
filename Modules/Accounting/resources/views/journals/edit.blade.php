@extends('dashboard.layout')

@section('content')
    <div class="container-fluid">
        <form action="{{ route('journals.update') }}?id={{ $journal->id }}" method="post" id="journalForm">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h2>تعديل قيد يومية</h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jdate">تاريخ</label>
                            <input name="jdate" type="date" class="form-control" value="{{ old('jdate', $journal->jdate) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="journal_id">رقم دفتري</label>
                            <input name="journal_id" type="text" class="form-control" value="{{ old('journal_id', $journal->journal_id) }}" readonly>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>عمليات</th>
                                    <th>مدين</th>
                                    <th>دائن</th>
                                    <th>اسم الحساب</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody id="journalRows">
                                @foreach ($journal->details as $detail)
                                    <tr class="journal-row">
                                        <td style="width: 100px;">
                                            <button type="button" class="btn btn-danger btn-sm remove-row">حذف</button>
                                        </td>
                                        <td style="width: 150px;">
                                            <input required class="form-control debit-input" type="number" name="debit[]" step="0.01" min="0" value="{{ $detail->debit }}">
                                        </td>
                                        <td style="width: 150px;">
                                            <input required class="form-control credit-input" type="number" name="credit[]" step="0.01" min="0" value="{{ $detail->credit }}">
                                        </td>
                                        <td>
                                            <select class="form-control" name="acc_id[]" required>
                                                <option value="">اختر حساب</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" {{ $detail->account_id == $account->id ? 'selected' : '' }}>
                                                        {{ $account->code }} - {{ $account->aname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="info_details[]" class="form-control" value="{{ $detail->info }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="addRow">+ إضافة صف</button>
                    </div>

                    <div class="form-group mb-3">
                        <label for="info">بيان</label>
                        <textarea name="info" id="info" class="form-control" rows="2">{{ old('info', $journal->info ?? '') }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>إجمالي مدين: </strong><span id="totalDebit" style="font-weight: bold;">0.00</span>
                        </div>
                        <div class="col-md-4">
                            <strong>إجمالي دائن: </strong><span id="totalCredit" style="font-weight: bold;">0.00</span>
                        </div>
                        <div class="col-md-4">
                            <strong>الفرق = </strong><span id="difference" style="font-weight: bold;">0</span>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-warning">تحديث</button>
                        <a href="{{ route('journals.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Template for new row
            var accountsOptions = `
                <option value="">اختر حساب</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->aname }}</option>
                @endforeach
            `;

            // Add new row
            $('#addRow').click(function() {
                var newRow = `
                    <tr class="journal-row">
                        <td style="width: 100px;">
                            <button type="button" class="btn btn-danger btn-sm remove-row">حذف</button>
                        </td>
                        <td style="width: 150px;">
                            <input required class="form-control debit-input" type="number" name="debit[]" step="0.01" min="0" value="0">
                        </td>
                        <td style="width: 150px;">
                            <input required class="form-control credit-input" type="number" name="credit[]" step="0.01" min="0" value="0">
                        </td>
                        <td>
                            <select class="form-control" name="acc_id[]" required>
                                ${accountsOptions}
                            </select>
                        </td>
                        <td>
                            <input type="text" name="info_details[]" class="form-control">
                        </td>
                    </tr>
                `;
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

                var diff = Math.abs(totalDebit - totalCredit);
                $('#difference').text(diff.toFixed(0));

                // Check if debit = credit
                if (diff > 0.01) {
                    $('#totalDebit, #totalCredit, #difference').css('color', 'red');
                } else {
                    $('#totalDebit, #totalCredit, #difference').css('color', 'green');
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
