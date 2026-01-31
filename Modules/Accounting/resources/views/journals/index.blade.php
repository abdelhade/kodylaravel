@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card_head">
                    <div class="row">
                        <div class="col">
                            <h2>اليومية العامة</h2>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <form action="{{ route('journals.index') }}" method="get">
                                        <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                                    </form>
                                </div>
                                <div class="col">
                                    <form action="{{ route('journals.index') }}" method="get">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="بحث..." value="{{ $search }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <a href="{{ route('journals.create') }}" class="btn btn-primary">قيد جديد</a>
                        </div>
                    </div>
                </div>
                <div class="card_body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table table_responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>تاريخ</th>
                                    <th>رقم القيد</th>
                                    <th>بيان</th>
                                    <th>عمليات</th>
                                    <th>مدين</th>
                                    <th>دائن</th>
                                    <th>الحساب</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($journals as $index => $journal)
                                    @php
                                        $debitEntries = collect($journal->details)->where('tybe', 0);
                                        $creditEntries = collect($journal->details)->where('tybe', 1);
                                        $totalRows = $debitEntries->count() + $creditEntries->count();
                                        $rowspan = $totalRows > 0 ? $totalRows : 1;
                                    @endphp
                                    
                                    @if($debitEntries->count() > 0)
                                        @foreach($debitEntries as $detailIndex => $detail)
                                            <tr>
                                                @if($detailIndex == 0)
                                                    <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                                                    <td rowspan="{{ $rowspan }}">{{ $journal->jdate }}</td>
                                                    <td rowspan="{{ $rowspan }}">{{ $journal->journal_id }}</td>
                                                    <td rowspan="{{ $rowspan }}">{{ $journal->details ?? '' }}</td>
                                                    <td rowspan="{{ $rowspan }}">
                                                        <a href="{{ route('journals.edit', ['id' => $journal->id]) }}" class="btn btn-warning btn-sm">تعديل</a>
                                                        <a href="{{ route('journals.destroy', ['id' => $journal->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                                                    </td>
                                                @endif
                                                <td>{{ number_format($detail->debit, 2) }}</td>
                                                <td>{{ number_format($detail->credit, 2) }}</td>
                                                <td>{{ $detail->code ?? '' }} - {{ $detail->aname ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    
                                    @if($creditEntries->count() > 0)
                                        @foreach($creditEntries as $detail)
                                            <tr>
                                                <td>{{ number_format($detail->debit, 2) }}</td>
                                                <td>{{ number_format($detail->credit, 2) }}</td>
                                                <td>{{ $detail->code ?? '' }} - {{ $detail->aname ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
