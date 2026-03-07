@extends('dashboard.layout')

@section('content')
    <!-- Select2 CSS -->
    <link href="{{ asset('native/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('native/plugins/select2/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- SheetJS for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <div class="container-fluid p-2">
        <div class="card ">
            <div class="card-header bg-primary">
                <h4 class="mb-0">كشف حساب</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.summary') }}" method="post" id="myForm" class="form mb-4">
                    @csrf
                    <div class="row align-items-end mb-4">
                        <div class="col-md-4">
                            <label class="form-label">اختر حساب</label>
                            <select class="select2 form-control" name="acc_id" id="acc" required>
                                <option value="0">اختر حساب</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}"
                                        {{ old('acc_id', $accountId) == $account->id ? 'selected' : '' }}>
                                        {{ $account->code }} - {{ $account->aname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">من</label>
                            <input type="date" value="{{ old('startdate', $startDate) }}" name="startdate" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">الي</label>
                            <input type="date" value="{{ old('enddate', $endDate) }}" name="enddate" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">اعرض</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-secondary" id="printBtn">
                                <i class="fa fa-print"></i> طباعه
                            </button>
                            <button type="button" class="btn btn-outline-success" id="exportExcel">
                                <i class="fa fa-table"></i> Excel
                            </button>
                        </div>
                    </div>
                    
                    
                </form>

                <div class="table-responsive" id="horsTable">
                    <div class="text-center mb-3 d-none d-print-block">
                        <h5>{{ $settings['company_name'] ?? '' }}</h5>
                        <p>{{ $settings['company_add'] ?? '' }} / {{ $settings['company_tel'] ?? '' }}</p>
                        <h4>كشف حساب
                            @if ($accountData)
                                {{ $accountData->aname }}
                            @endif
                        </h4>
                    </div>

                    <table class="table table-bordered table-hover table-striped">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th style="width: 50px;">م</th>
                                <th style="width: 120px;">التاريخ</th>
                                <th>اسم العملية</th>
                                <th style="width: 120px;">مدين</th>
                                <th style="width: 120px;">دائن</th>
                                <th style="width: 120px;">رصيد متحرك</th>
                                <th style="width: 200px;">الحساب المقابل</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($accountId && $accountId != 0 && count($transactions) > 0)
                                @php
                                    $x = 0;
                                    $cumulativeBalance = $accountBalance;
                                @endphp
                                @foreach ($transactions as $transaction)
                                    @php
                                        $x++;
                                        $debit = $transaction->debit ?? 0;
                                        $credit = $transaction->credit ?? 0;
                                        $cumulativeBalance += $debit - $credit;
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $x }}</td>
                                        <td>{{ $transaction->pro_date }}</td>
                                        <td>{{ $transaction->type_name }}</td>
                                        <td class="td4">{{ number_format($debit, 2) }}</td>
                                        <td class="td5">{{ number_format($credit, 2) }}</td>
                                        <td class="td6 fw-bold">{{ number_format($cumulativeBalance, 2) }}</td>
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
                        <tfoot class="table-secondary">
                            <tr class="text-center fw-bold">
                                <th colspan="3">الإجمالي</th>
                                <th class="sumth4">0</th>
                                <th class="sumth5">0</th>
                                <th colspan="2">صافي الحركة</th>
                                <th class="net">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
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
            var wbout = XLSX.write(wb, {
                bookType: "xlsx",
                type: "array"
            });
            var blob = new Blob([wbout], {
                type: "application/octet-stream"
            });
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
