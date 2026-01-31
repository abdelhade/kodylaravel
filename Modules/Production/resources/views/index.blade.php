@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title float-left">
                        <h2>الوحدات المنتجة</h2>
                    </div>
                    <a href="{{ route('production.create') }}" class="btn float-right bg-green-600 text-slate-50">+</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>id</th>
                                    <th>التاريخ</th>
                                    <th>اسم الموظف</th>
                                    <th>ع الوحدات</th>
                                    <th>س الوحدة</th>
                                    <th>القيمة</th>
                                    <th>بيان</th>
                                    <th>ملاحظات</th>
                                    <th><span class="fa fa-pen"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $index = 0;
                                @endphp
                                @forelse($groupedProductions as $sndId => $productions)
                                    @foreach($productions as $production)
                                        @php $index++; @endphp
                                        <tr>
                                            <td class="p-1">{{ $index }}</td>
                                            <td class="p-1">{{ $production->snd_id }}</td>
                                            <td class="p-1">{{ $production->date }}</td>
                                            <td class="p-1">{{ $production->emp_name }}</td>
                                            <td class="p-1">{{ $production->qty }}</td>
                                            <td class="p-1">{{ number_format($production->price, 2) }}</td>
                                            <td class="p-1">{{ number_format($production->value, 2) }}</td>
                                            <td class="p-1">{{ $production->info ?? '-' }}</td>
                                            <td class="p-1">{{ $production->info2 ?? '-' }}</td>
                                            <td class="p-1">
                                                @if($loop->first)
                                                    <a href="{{ route('production.edit', ['edit' => $production->snd_id]) }}" class="btn btn-sm bg-yellow-300">
                                                        <span class="fa fa-pen"></span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">لا توجد وحدات منتجة</td>
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
@endsection
