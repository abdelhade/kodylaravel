@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form action="{{ route('start-balance.store') }}" method="post" id="startBalanceForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="filter">
                            <div class="row">
                                <div class="col-md-4">
                                    فلتر
                                    <select name="" id="accountFilter" class="form form-control">
                                        <option value="">جميع الحسابات</option>
                                        @foreach($basicAccounts as $basic)
                                            <option value="{{ $basic->code }}">{{ $basic->aname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    بحث
                                    <input type="text" id="searchInput" class="form form-control" placeholder="بحث">
                                </div>
                                <div class="col-md-4">
                                    <div class="btn bg-yellow-400" id="edit_balance">
                                        <i class="fa fa-pen"></i>
                                        <br>
                                        <p>بدء تعديل الأرصدة الافتتاحية</p>
                                    </div>
                                    <button class="btn bg-green-400" type="submit" name="save_balance">
                                        <i class="fa fa-save"></i>
                                        <br>
                                        <p>حفظ التعديلات</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table">
                            <table class="table table-stripped table-hover table-sortable" id="accountsTable">
                                <thead>
                                    <tr>
                                        <th>الكود</th>
                                        <th>اسم الحساب</th>
                                        <th>الرصيد الافتتاحي الجديد</th>
                                        <th>قيمة التسوية</th>
                                        <th>الرصيد الافتتاحي السابق</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($accounts as $account)
                                        <tr>
                                            <td>
                                                {{ $account->code }}
                                                <input name="acc_id[]" type="hidden" class="acc_id" value="{{ $account->id }}">
                                            </td>
                                            <td>{{ $account->aname }}</td>
                                            <td>
                                                <input name="newbalance[]" type="number" step="0.01" 
                                                       class="form form-control new-balance font-bold m-0 p-0 {{ $account->balance < 0 ? 'text-red-500' : '' }}" 
                                                       value="{{ $account->balance }}" 
                                                       disabled 
                                                       @if($account->editable == 0) readonly @endif>
                                            </td>
                                            <td>
                                                <input type="text" readonly class="form form-control settle m-0 p-0" value="00.00">
                                            </td>
                                            <td class="old-balance {{ $account->balance < 0 ? 'text-red-500' : '' }}">
                                                {{ number_format($account->balance, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <b>إجمالي مدين</b>
                                <input type="text" id="total_debit" value="00.00" disabled class="form-control">
                                <b>إجمالي دائن</b>
                                <input type="text" id="total_credit" value="00.00" disabled class="form-control">
                                <p>الفرق</p>
                                <input type="text" id="total_diff" value="00.00" disabled class="form-control">
                            </div>
                            <div class="col">
                                <b>فرق الميزانية</b>
                                <input type="text" id="total_diff_budget" value="00.00" disabled class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enable editing of balances
    document.getElementById('edit_balance').addEventListener('click', function() {
        const newBalances = document.querySelectorAll('.new-balance');
        newBalances.forEach(function(input) {
            if (!input.readOnly) {
                input.disabled = false;
            }
        });
    });

    // Filter by account code
    document.getElementById('accountFilter').addEventListener('change', function() {
        const selectedCode = this.value;
        filterAccounts(selectedCode);
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        searchAccounts(searchTerm);
    });

    // Update totals dynamically
    function updateTotals() {
        let totalDebit = 0;
        let totalCredit = 0;
        let totalDiff = 0;
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(function(row) {
            const newBalance = parseFloat(row.querySelector('.new-balance').value) || 0;
            const oldBalance = parseFloat(row.querySelector('.old-balance').textContent.replace(/,/g, '')) || 0;
            const settle = parseFloat(row.querySelector('.settle').value) || 0;

            if (newBalance > 0) {
                totalDebit += newBalance;
            } else {
                totalCredit += Math.abs(newBalance);
            }
            totalDiff += Math.abs(newBalance - oldBalance);
        });

        document.getElementById('total_debit').value = totalDebit.toFixed(2);
        document.getElementById('total_credit').value = totalCredit.toFixed(2);
        document.getElementById('total_diff').value = totalDiff.toFixed(2);
    }

    // Call updateTotals on input change
    const balanceInputs = document.querySelectorAll('.new-balance');
    balanceInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            // Change color if balance is less than zero
            const newBalance = parseFloat(input.value) || 0;
            const row = input.closest('tr');
            if (newBalance < 0) {
                input.classList.add('text-red-500');
            } else {
                input.classList.remove('text-red-500');
            }

            // Update the settle value
            const oldBalance = parseFloat(row.querySelector('.old-balance').textContent.replace(/,/g, '')) || 0;
            const settleInput = row.querySelector('.settle');
            settleInput.value = (oldBalance - newBalance).toFixed(2);

            // Update totals after each input change
            updateTotals();
        });
    });

    // Search accounts based on search input
    function searchAccounts(term) {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(function(row) {
            const accountName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const accountCode = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            if (accountName.includes(term) || accountCode.includes(term)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateTotals();
    }

    // Filter accounts by selected code
    function filterAccounts(code) {
        if (!code) {
            // Show all if no filter
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                row.style.display = '';
            });
            updateTotals();
            return;
        }

        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(function(row) {
            const accountCode = row.querySelector('td:nth-child(1)').textContent.trim();
            if (accountCode.startsWith(code)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateTotals();
    }

    // Initial totals calculation
    updateTotals();
});
</script>
@endsection
