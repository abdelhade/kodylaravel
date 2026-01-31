@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="h3">
                                قائمة العملاء::
                                <a href="{{ route('clients.create') }}">
                                    <div class="btn btn-primary">جديد</div>
                                </a>
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الميلاد</th>
                                    <th>الشكوى</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patients as $index => $patient)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th>
                                            <a class="btn btn-dark" href="{{ route('clients.profile', ['id' => $patient->id]) }}">
                                                {{ $patient->name }}
                                            </a>
                                        </th>
                                        <th>{{ $patient->dateofbirth ?? '-' }}</th>
                                        <th>{{ $patient->diseses ?? '-' }}</th>
                                        <th>
                                            <a href="{{ route('clients.edit', ['id' => $patient->id]) }}">
                                                <div class="btn btn-warning btn-sm">تعديل</div>
                                            </a>
                                            <form action="{{ route('clients.destroy', ['id' => $patient->id]) }}" method="post" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                            </form>
                                        </th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا توجد عملاء</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الميلاد</th>
                                    <th>الشكوى</th>
                                    <th>عمليات</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@if(request('w') == 'del')
    <script>
        alert("لا يمكن الحذف بسبب وجود بعض البيانات المرتبطة .. تأكد من مسح البيانات المرتبطة ثم حاول مرة أخرى");
    </script>
@endif
@endsection
