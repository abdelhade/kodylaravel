@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>محلل العمل اليومي - {{ $report_name }}</h3>
              
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12 mb-2">
                                <label>من</label>
                                <input class="form-control" type="date" value="{{ $strtdate }}" name="strtdate">
                            </div>
                            <div class="col-md-4 col-sm-6 col-12 mb-2">
                                <label>إلى</label>
                                <input class="form-control" type="date" value="{{ $enddate }}" name="enddate">
                            </div>
                            <div class="col-md-4 col-12 mb-2">
                                <label class="d-none d-md-block">&nbsp;</label>
                                <button class="btn btn-primary btn-block" type="submit">
                                    <i class="fa fa-search"></i> بحث
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm" id="operationsTable" data-page-length="10">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الوقت و التاريخ</th>
                                    <th>اسم العملية</th>
                                    <th>قيمة العملية</th>
                                    <th>صافي العملية</th>
                                    <th>الحساب</th>
                                    <th>الحساب المقابل</th>
                                    <th>المخزن</th>
                                    <th>الموظف</th>
                                    <th>الربح</th>
                                    <th>المستخدم</th>
                                    <th>معرف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $x = 0; @endphp
                                @foreach($operations as $rowop)
                                    @php 
                                        $x++;
                                        $proid = $rowop->id;
                                        $tybe = $rowop->pro_tybe;
                                        $proTypeName = $proTypes[$tybe] ?? '';
                                        $acc1Name = $accounts[$rowop->acc1] ?? '';
                                        $acc2Name = $accounts[$rowop->acc2] ?? '';
                                        $storeName = ($rowop->store_id > 0 && isset($accounts[$rowop->store_id])) ? $accounts[$rowop->store_id] : '';
                                        $empName = ($rowop->emp_id > 0 && isset($accounts[$rowop->emp_id])) ? $accounts[$rowop->emp_id] : '';
                                        $userName = $users[$rowop->user] ?? '';
                                    @endphp
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td>{{ $rowop->crtime }}</td>
                                        <td>
                                            <a class="btn btn-block btn-light border" 
                                               href="{{ asset('native/print/' . (($tybe == 4 || $tybe == 3) ? 'print_sales' : 'receipt') . '.php?id=' . $proid) }}" 
                                               target="_blank">
                                                {{ $proTypeName }}
                                            </a>
                                        </td>
                                        <td class="value">{{ $rowop->pro_value }}</td>
                                        <td class="fatnet {{ $rowop->pro_value != $rowop->fat_net ? 'bg-yellow-300' : '' }}">{{ $rowop->fat_net }}</td>
                                        <td>{{ $acc1Name }}</td>
                                        <td>{{ $acc2Name }}</td>
                                        <td>{{ $storeName }}</td>
                                        <td>{{ $empName }}</td>
                                        <td class="prft">{{ $rowop->profit }}</td>
                                        <td>{{ $userName }}</td>
                                        <td>
                                            {{ $rowop->id }}
                                            <a href="{{ route('operations_summary', ['q' => $q, 'h' => md5($proid), 'inv' => $proid, 't' => md5($tybe)]) }}">
                                                <i class="fa fa-barcode"></i>
                                            </a>
                                            
                                            @if(in_array($tybe, [3, 4, 9]))
                                            <a href="{{ route('sales.index', ['edit_id' => $rowop->id]) }}" class="btn btn-sm btn-warning" title="تعديل">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endif

                                            <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $rowop->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <form action="{{ asset('native/do/dodel_invoice.php?id=' . $rowop->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="q" value="{{ $q }}">
                                            
                                                <div class="modal fade" id="deleteModal{{ $rowop->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف {{ $rowop->id }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>هل أنت متأكد من أنك تريد حذف هذه الفاتورة؟</p>
                                                                <p><strong>رقم الفاتورة:</strong> {{ $rowop->id }}</p>
                                                                <p><strong>نوع العملية:</strong> {{ $proTypeName }}</p>
                                                                <label for="pass">كلمة المرور:</label>
                                                                <input type="password" name="pass" class="form-control hover:bg-orange-300" placeholder="أدخل كلمة مرور الحذف" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-danger">حذف</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>اجمالي</td>
                                    <td class="bg-zinc-100" id="total"></td>
                                    <td>_ _</td>
                                    <td></td>
                                    <td>صافي</td>
                                    <td class="" id="fatnet"></td>
                                    <td>_ _</td>
                                    <td>ارباح</td>
                                    <td class="" id="profit"></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const total = Array.from(document.querySelectorAll(".value")).reduce((sum, el) => sum + parseFloat(el.textContent || 0), 0);
        const fatnet = Array.from(document.querySelectorAll(".fatnet")).reduce((sum, el) => sum + parseFloat(el.textContent || 0), 0);
        const profit = Array.from(document.querySelectorAll(".prft")).reduce((sum, el) => sum + parseFloat(el.textContent || 0), 0);
        document.getElementById("total").textContent = total.toFixed(2);
        document.getElementById("fatnet").textContent = fatnet.toFixed(2);
        document.getElementById("profit").textContent = profit.toFixed(2);
    });
</script>
@endsection
