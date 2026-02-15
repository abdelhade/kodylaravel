@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="hazaz">
                                قائمة الحسابات
                                @if($accountName)
                                    \ {{ $accountName }}
                                @endif
                            </h3>
                        </div>
                        <div class="col">
                            <a href="{{ route('accounts.create', $parentId ? ['parent_id' => $parentId] : []) }}">
                                <div class="btn btn-info float-right hadi-white-flash" id="addNewElement">جديد</div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col">
                            <input class="form-control form-control-sm frst" type="text" name="" id="itmsearch" placeholder="بحث بالكود | اسم الحساب | id">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover table-stripped" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الرصيد</th>
                                    <th>العنوان</th>
                                    <th>التليفون</th>
                                    <th>id</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accounts as $index => $account)
                                    <tr class="tr1">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <form action="{{ route('summary') }}" method="post" class="d-inline">
                                                @csrf
                                                <input type="hidden" value="{{ $account->id }}" name="acc_id">
                                                <button class="btn btn-light btn-block" type="submit">
                                                    {{ $account->code }}-{{ $account->aname }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>{{ number_format($account->balance ?? 0, 2) }}</td>
                                        <td>{{ $account->address ?? '-' }}</td>
                                        <td>{{ $account->phone ?? '-' }}</td>
                                        <td>{{ $account->id }}</td>
                                        <td>
                                            <a href="/edit_account?id={{ $account->id }}" class="btn btn-warning">
                                                <i class="fa fa-pen text-yellow-50"></i>
                                            </a>
                                            <a href="/edit_account/delete?id={{ $account->id }}" class="btn btn-danger" onclick="return confirm('هل تريد حذف هذا الحساب؟')">
                                                <i class="fa fa-trash text-yellow-50"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">لا توجد حسابات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الرصيد</th>
                                    <th>العنوان</th>
                                    <th>التليفون</th>
                                    <th>id</th>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Search functionality
    $('#itmsearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('#myTable tbody tr').each(function() {
            const code = $(this).find('td:eq(1)').text().toLowerCase();
            const name = $(this).find('td:eq(1)').text().toLowerCase();
            const id = $(this).find('td:eq(5)').text().toLowerCase();
            
            if (code.includes(searchTerm) || name.includes(searchTerm) || id.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection
