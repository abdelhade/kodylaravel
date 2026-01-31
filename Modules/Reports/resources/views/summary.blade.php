@extends('dashboard.layout')

@section('content')
<!-- Select2 CSS -->
<link href="{{ asset('native/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('native/plugins/select2/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
<!-- SheetJS for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('reports.summary') }}" method="post" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <p>اختر حساب</p>
                                    <select class="select2 form-control" name="acc_id" id="acc" required>
                                        <option value="0">اختر حساب</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ old('acc_id', $accountId) == $account->id ? 'selected' : '' }}>
                                                {{ $account->code }} - {{ $account->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>التاريخ</b>
                                <div class="form-group">
                                    من <input type="date" value="{{ old('startdate', $startDate) }}" name="startdate" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    الي <input type="date" value="{{ old('enddate', $endDate) }}" name="enddate" class="form-control" required>
                                </div>
                                <p>
                                    رصيد الحساب: <strong>{{ number_format($accountBalance, 2) }}</strong>
                                </p>
                            </div>
                            <div class="col-sm-1">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">اعرض</button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-block" id="printBtn">
                                    طباعه <i class="fa fa-solid fa-print"></i>
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm btn-block" id="exportExcel">
                                    <i class="fa fa-solid fa-table"></i> Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="horsTable">
                        <b>{{ $settings['company_name'] ?? '' }} / {{ $settings['company_tel'] ?? '' }}</b>
                        <p>{{ $settings['company_add'] ?? '' }}</p>
                        
                        <center>
                            <h3 class='hazaz'>كشف حساب 
                                @if($accountData)
                                    {{ $accountData->aname }}
                                @endif
                            </h3>
                        </center>
                        
                        <table class="table table-bordered" style="text-align:center" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>التاريخ</th>
                                    <th>اسم العملية</th>
                                    <th>مدين</th>
                                    <th>دائن</th>
                                    <th>رصيد متحرك</th>
                                    <th>الحساب المقابل</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($accountId && $accountId != 0 && count($transactions) > 0)
                                    @php
                                        $x = 0;
                                        $cumulativeBalance = $accountBalance;
                                    @endphp
                                    @foreach($transactions as $transaction)
                                        @php
                                            $x++;
                                            $debit = $transaction->debit ?? 0;
                                            $credit = $transaction->credit ?? 0;
                                            $cumulativeBalance += ($debit - $credit);
                                        @endphp
                                        <tr>
                                            <td>{{ $x }}</td>
                                            <td>{{ $transaction->pro_date }}</td>
                                            <td>{{ $transaction->type_name }}</td>
                                            <td class="td4">{{ number_format($debit, 2) }}</td>
                                            <td class="td5">{{ number_format($credit, 2) }}</td>
                                            <td class="td6">{{ number_format($cumulativeBalance, 2) }}</td>
                                            <td>{{ $transaction->counter_account }}</td>
                                            <td>{{ $transaction->info ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                @elseif($accountId && $accountId != 0)
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <b>لا توجد معاملات في الفترة المحددة</b>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <b>ابدأ اختيار الحساب و حدد التاريخ</b>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="bg-sky-100" style="font-size:20px">
                                    <th></th>
                                    <th></th>
                                    <th>اجمالي مدين</th>
                                    <th class="sumth4">0</th>
                                    <th>اجمالي دائن</th>
                                    <th class="sumth5">0</th>
                                    <th>صافي الحركة</th>
                                    <th class="net">0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('native/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#acc').select2();
    
    // Calculate cumulative balance
    var cumulativeSum = {{ $accountBalance ?? 0 }};
    $('#horsTable tbody tr').each(function() {
        var td4Value = parseFloat($(this).find('.td4').text().replace(/,/g, '')) || 0;
        var td5Value = parseFloat($(this).find('.td5').text().replace(/,/g, '')) || 0;
        if (!isNaN(td4Value) && !isNaN(td5Value)) {
            cumulativeSum += td4Value - td5Value;
            $(this).find('.td6').text(cumulativeSum.toFixed(2));
        }
    });

    // Calculate totals
    var sum4 = 0;
    $(".td4").each(function() { 
        sum4 += parseFloat($(this).text().replace(/,/g, '')) || 0; 
    });
    $(".sumth4").text(sum4.toFixed(2));

    var sum5 = 0;
    $(".td5").each(function() { 
        sum5 += parseFloat($(this).text().replace(/,/g, '')) || 0; 
    });
    $(".sumth5").text(sum5.toFixed(2));

    $(".net").text((sum4 - sum5).toFixed(2));
});

// Form validation
document.getElementById("myForm").addEventListener("submit", function(event) {
    var selectedValue = document.getElementById("acc").value;
    if (selectedValue === "0") {
        alert("من فضلك اختار حساب");
        event.preventDefault();
    }
});

// Print function
document.getElementById("printBtn").addEventListener("click", function() {
    var printContents = document.getElementById("horsTable").outerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
});

// Export to Excel
document.getElementById("exportExcel").addEventListener("click", function() {
    var table = document.querySelector("#horsTable table");
    var rows = table.querySelectorAll("tr");
    var data = [];

    rows.forEach(function(row) {
        var rowData = [];
        row.querySelectorAll("th, td").forEach(function(cell) {
            rowData.push(cell.innerText);
        });
        data.push(rowData);
    });

    // Create Excel file
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.aoa_to_sheet(data);
    XLSX.utils.book_append_sheet(wb, ws, "كشف حساب");

    // Save Excel file
    var wbout = XLSX.write(wb, {bookType: "xlsx", type: "array"});
    var blob = new Blob([wbout], {type: "application/octet-stream"});
    var fileName = "كشف_حساب_" + new Date().getTime() + ".xlsx";

    // Trigger file download
    if (typeof window.navigator.msSaveBlob !== "undefined") {
        window.navigator.msSaveBlob(blob, fileName);
    } else {
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.style.display = "none";
        a.href = url;
        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    }
});
</script>
@endsection
