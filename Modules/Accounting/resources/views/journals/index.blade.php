@extends('dashboard.layout')

@section('content')
    <div class="container-fluid p-4">
        <div class="card ">
            <div class="card-header p-2">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h2>اليومية العامة</h2>
                    </div>
                    <div class="col-md-3">
                        <form action="{{ route('journals.index') }}" method="get">
                            <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form action="{{ route('journals.index') }}" method="get">
                            <input type="text" name="search" id="search" class="form-control" placeholder="بحث..." value="{{ $search }}">
                        </form>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="{{ route('journals.create') }}" class="btn btn-primary">+ قيد جديد</a>
                    </div>
                </div>
            </div>
            <div class="card_body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table table_responsive ">
                    <table class="table table-striped table-bordered overflow-x-auto">
                        <thead>
                            <tr>
                            <tr>
                                <th>م</th>
                                <th>تاريخ</th>
                                <th>رقم القيد</th>
                                <th>بيان</th>
                                <th>مدين</th>
                                <th>دائن</th>
                                <th>الحساب</th>
                                <th>عمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($journals as $index => $journal)
                                @php
                                    $debitEntries = collect($journal->details)->where('tybe', 0);
                                    $creditEntries = collect($journal->details)->where('tybe', 1);
                                    $totalRows = $debitEntries->count() + $creditEntries->count();
                                    $rowspan = $totalRows > 0 ? $totalRows : 1;
                                @endphp

                                @if ($debitEntries->count() > 0)
                                    @foreach ($debitEntries as $detailIndex => $detail)
                                        <tr>
                                            @if ($detailIndex == 0)
                                                <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                                                <td rowspan="{{ $rowspan }}">{{ $journal->jdate }}</td>
                                                <td rowspan="{{ $rowspan }}">{{ $journal->journal_id }}</td>
                                                <td rowspan="{{ $rowspan }}">{{ $journal->info ?? '' }}</td>
                                            @endif
                                            <td>{{ number_format($detail->debit, 2) }}</td>
                                            <td>{{ number_format($detail->credit, 2) }}</td>
                                            <td>{{ $detail->code ?? '' }} - {{ $detail->aname ?? '' }}</td>
                                            @if ($detailIndex == 0)
                                                <td rowspan="{{ $rowspan }}">
                                                    <a href="{{ route('journals.edit', ['id' => $journal->id]) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('journals.destroy', ['id' => $journal->id]) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('هل أنت متأكد؟')">
                                                        <i class="fa fa-trash"></i>
                                                        
                                                    </a>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @endif

                                @if ($creditEntries->count() > 0)
                                    @foreach ($creditEntries as $detail)
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
@endsection
