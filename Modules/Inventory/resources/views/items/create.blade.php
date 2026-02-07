@extends('dashboard.layout')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm">

                <form id="myForm" action="{{ route('items.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    {{-- HEADER --}}
                    <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="mb-0 fw-bold text-info">إضافة صنف</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-info btn-sm">حفظ</button>
                            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary btn-sm">عودة</a>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- بيانات أساسية --}}
                        <div class="box">
                            <div class="row g-3">

                                <div class="col-md-3 mb-2">
                                    <label>رقم الصنف</label>
                                    <input readonly value="{{ $nextCode }}" name="code"
                                        class="form-control form-control-sm">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>الباركود</label>
                                    <input required value="{{ $nextCode }}" name="barcode"
                                        class="form-control form-control-sm">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>اسم الصنف</label>
                                    <datalist id="inamelist">
                                        @foreach ($itemNames as $name)
                                            <option value="{{ $name }}">
                                        @endforeach
                                    </datalist>
                                    <input list="inamelist" name="iname" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>اسم ثاني</label>
                                    <input name="name2" class="form-control form-control-sm">
                                </div>

                                <div class="col-md-12">
                                    <label>التفاصيل</label>
                                    <input name="info" class="form-control form-control-sm">
                                </div>

                            </div>
                        </div>

                        {{-- الوحدات --}}
                        <div class="box">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>الوحدات والأسعار</strong>
                                <button type="button" id="addUnit" class="btn btn-info btn-sm">+ إضافة وحدة</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead>
                                        <tr>
                                            <th>الوحدة</th>
                                            <th>معامل</th>
                                            <th>باركود</th>
                                            <th>تكلفة</th>
                                            <th>قطاعي</th>
                                            <th>جملة</th>
                                            <th>السوق</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="urow">
                                            <td>
                                                <select name="unit_id[]" class="form-select form-select-sm">
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->uname }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input name="u_val[]" value="1" readonly
                                                    class="form-control form-control-sm"></td>
                                            <td><input name="unit_barcode[]" value="{{ $nextCode }}"
                                                    class="form-control form-control-sm"></td>
                                            <td><input name="cost_price[]" value="0"
                                                    class="form-control form-control-sm"></td>
                                            <td><input name="price1[]" value="0" class="form-control form-control-sm">
                                            </td>
                                            <td><input name="price2[]" value="0" class="form-control form-control-sm">
                                            </td>
                                            <td><input name="market_price[]" value="0"
                                                    class="form-control form-control-sm"></td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm deleteRow">×</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- التصنيفات --}}
                        <div class="box">
                            <div class="row g-3">
                                <div class="col-md-6 form-group">
                                    <label>المجموعة</label>
                                    <select name="group1" class="form-select form-select-sm form-control">
                                        <option value="">اختر</option>
                                        @foreach ($groups1 as $g)
                                            <option value="{{ $g->id }}">{{ $g->gname }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>التصنيف</label>
                                    <select name="group2" class="form-select form-select-sm form-control">
                                        <option value="">اختر</option>
                                        @foreach ($groups2 as $g)
                                            <option value="{{ $g->id }}">{{ $g->gname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- الصور --}}
                        <div class="mb-3">
                            <label for="images" class="form-label">صور الصنف</label>
                            <input class="form-control" type="file" id="images" name="imgs[]"  multiple>
                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer bg-white d-flex justify-content-between">
                        <small class="text-muted">الحقول الأساسية مطلوبة</small>
                        <button class="btn btn-info px-4">حفظ</button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    {{-- JS نفس اللوجيك --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#addUnit').click(function() {
                let clone = $('.urow').first().clone();
                clone.find('input').val('');
                clone.find('input[name="u_val[]"]').val(1).prop('readonly', false);
                $('.urow').last().after(clone);
            });

            $(document).on('click', '.deleteRow', function() {
                if ($('.urow').length > 1)
                    $(this).closest('.urow').remove();
                else alert('لا يمكن حذف الوحدة الأولى');
            });

        });
    </script>
@endsection
