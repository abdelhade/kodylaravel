@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col"><h4 class="hazaz">المدد الإيجارية</h4></div>
                        <div class="col"></div>
                        <div class="col">
                            <button onclick="printTable()" class="btn btn-info btn-lg hadi-white-flash">طباعة</button>
                        </div>
                    </div>
                    @if($start && $end)
                        <div class="row mt-2">
                            <div class="col">
                                <p>إجمالي المدد الإيجارية من {{ $start }} إلى {{ $end }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table table-responsive" id="myTable_wrapper">
                        <table class="table table-bordered table-hover" id="myTable" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>اسم الوحدة</th>
                                    <th>اسم العميل</th>
                                    <th>تاريخ الاستحقاق</th>
                                    <th>المستحق</th>
                                    <th>المدفوع</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($installments as $index => $installment)
                                    <tr class="{{ $installment->is_paid ? 'bg-secondary' : ($installment->is_expired ? 'bg-yellow' : '') }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $installment->unit_name }}</td>
                                        <td>
                                            <a style="color:black;" href="{{ route('vouchers.create', ['t' => 'recive', 'acc' => $installment->cl_id, 'v' => $installment->ins_value, 'ins' => $installment->id]) }}">
                                                {{ $installment->client_name }}
                                            </a>
                                        </td>
                                        <td>{{ $installment->ins_date }}</td>
                                        <td>{{ $installment->ins_value }}</td>
                                        <td>{{ $installment->ins_paid }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">لا توجد أقساط</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function printTable() {
    window.print();
}
</script>
@endsection
