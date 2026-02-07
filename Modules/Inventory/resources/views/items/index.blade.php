@extends('dashboard.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">الأصناف</h3>
                <small class="text-muted">إدارة جميع الأصناف المخزنية مع وحداتها وأسعارها</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('items.create') }}" id="addNewElement" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> صنف جديد (F3)
                </a>
                <a href="{{ route('items.recost') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-calculator me-1"></i> إعادة حساب
                </a>
                <button id="reindex" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-sync-alt me-1"></i> إعادة الفهرسة
                </button>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pb-0">
                <div class="row align-items-center">
                    <div class=" mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text ">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="search" id="search" class="rounded form-control " placeholder="ابحث باسم الصنف أو الكود أو الوصف...">
                        </div>
                    </div>
                   
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="horsTable" class="table table-striped table-hover align-middle text-center">
                        <thead>
                            <tr class="bg-light">
                                <th>م</th>
                                <th>رقم الصنف</th>
                                <th>الاسم</th>
                                <th>الكميه</th>
                                <th>الوحدة</th>
                                <th>الوصف</th>
                                <th>سعر البيع</th>
                                <th>سعر الشراء</th>
                                <th>سعر التكلفة</th>
                                <th>سعر السوق</th>
                                <th>عمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td>{{ ($page - 1) * 1000 + $index + 1 }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td><b>{{ $item->iname }}</b></td>
                                    <td class="qty" data-row-id="{{ $item->id }}" data-original-qty="{{ $item->itmqty ?? 0 }}">
                                        <a class="btn btn-sm btn-light" id="item_qty_{{ $item->id }}" href="{{ route('items.summary', ['id' => $item->id]) }}">
                                            {{ $item->itmqty ?? 0 }}
                                        </a>
                                    </td>
                                    <td class="unit">
                                        <select name="" id="item_unit_{{ $item->id }}" class="form-control form-control-sm" data-row-id="{{ $item->id }}">
                                            @foreach($item->units as $unit)
                                                <option value="{{ $unit->u_val }}">
                                                    {{ $unit->uname }} [{{ $unit->u_val }}]
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ $item->info }}</td>
                                    <td><b>{{ $item->price1 }}</b></td>
                                    <td><b>{{ $item->last_price ?? 0 }}</b></td>
                                    <td><b>{{ $item->cost_price }}</b></td>
                                    <td><b>{{ $item->market_price }}</b></td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="{{ route('items.edit', ['edit' => $item->id]) }}">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteitm{{ $item->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteitm{{ $item->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content bg-danger">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">تحذير</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>هل تريد بالتأكيد الحذف {{ $item->iname }}؟</p>
                                                        <form action="{{ route('items.destroy') }}?id={{ $item->id }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="password" class="form-control" name="password" id="password" placeholder="كلمة المرور">
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="submit" class="btn btn-flat btn-sm btn-outline-light btn-block" id="sub">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td class='p-2' colspan="11" class="text-center py-5">
                                    <div class="text-muted text-center">
                                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                                        <p>لا توجد أصناف</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($totalPages > 1)
                        <div class="pagination">
                            <ul class="pagination">
                                @for($i = 1; $i <= $totalPages; $i++)
                                    <li class="page-item {{ $i == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ route('items.index', ['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Listen for changes in unit dropdowns
    $('.unit select').change(function() {
        var rowId = $(this).data('row-id');
        var selectedUnitValue = parseFloat($(this).val());
        var qtyElement = $('#item_qty_' + rowId);
        var originalQty = parseFloat($('.qty[data-row-id="' + rowId + '"]').data('original-qty'));

        if (selectedUnitValue != 0) {
            var newQty = originalQty / selectedUnitValue;
            qtyElement.text(newQty.toFixed(2));
        }
    });

    // Reindex functionality
    $('#reindex').click(function() {
        $.ajax({
            url: '{{ asset("native/js/ajax/reindex.php") }}',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                $('#response-message').html('<div class="alert alert-success">' + response.message + '</div>');
            },
            error: function(xhr, status, error) {
                $('#response-message').html('<div class="alert alert-danger">حدث خطأ: ' + error + '</div>');
            }
        });
    });

    // Search functionality
    $('#search').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#horsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
@endsection
