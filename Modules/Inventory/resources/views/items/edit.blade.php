@extends('dashboard.layout')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm">

                <form id="myForm" action="{{ route('items.update') }}?edit={{ $item->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- HEADER --}}
                    <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="mb-0 fw-bold text-success">تعديل الصنف</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm">تحديث</button>
                            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary btn-sm">عودة</a>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- بيانات أساسية --}}
                        <div class="box">
                            <div class="row g-3">

                                <div class="col-md-3 mb-2">
                                    <label>رقم الصنف</label>
                                    <input readonly value="{{ $item->code }}" name="code"
                                        class="form-control form-control-sm">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>الباركود</label>
                                    <input required value="{{ $item->barcode }}" name="barcode"
                                        class="form-control form-control-sm">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>اسم الصنف</label>
                                    <datalist id="inamelist">
                                        @foreach ($itemNames as $name)
                                            <option value="{{ $name }}">
                                        @endforeach
                                    </datalist>
                                    <input list="inamelist" name="iname" value="{{ old('iname', $item->iname) }}" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label>اسم ثاني</label>
                                    <input name="name2" value="{{ old('name2', $item->name2) }}" class="form-control form-control-sm">
                                </div>

                                <div class="col-md-12">
                                    <label>التفاصيل</label>
                                    <input name="info" value="{{ old('info', $item->info) }}" class="form-control form-control-sm">
                                </div>

                            </div>
                        </div>

                        {{-- الوحدات --}}
                        <div class="box">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>الوحدات والأسعار</strong>
                                <button type="button" id="addUnit" class="btn btn-success btn-sm">+ إضافة وحدة</button>
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
                                        @foreach ($itemUnits as $itemUnit)
                                        <tr class="urow">
                                            <td>
                                                <select name="unit_id[]" class="form-select form-select-sm">
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}" {{ $unit->id == $itemUnit->unit_id ? 'selected' : '' }}>{{ $unit->uname }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input name="u_val[]" value="{{ $itemUnit->u_val }}" readonly class="form-control form-control-sm"></td>
                                            <td><input name="unit_barcode[]" value="{{ $itemUnit->unit_barcode }}" class="form-control form-control-sm"></td>
                                            <td><input name="cost_price[]" value="{{ $itemUnit->cost_price }}" class="form-control form-control-sm"></td>
                                            <td><input name="price1[]" value="{{ $itemUnit->price1 }}" class="form-control form-control-sm"></td>
                                            <td><input name="price2[]" value="{{ $itemUnit->price2 }}" class="form-control form-control-sm"></td>
                                            <td><input name="market_price[]" value="{{ $marketPrice }}" class="form-control form-control-sm"></td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm deleteRow">×</button>
                                            </td>
                                        </tr>
                                        @endforeach
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
                                            <option value="{{ $g->id }}" {{ old('group1', $item->group1) == $g->id ? 'selected' : '' }}>{{ $g->gname }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>التصنيف</label>
                                    <select name="group2" class="form-select form-select-sm form-control">
                                        <option value="">اختر</option>
                                        @foreach ($groups2 as $g)
                                            <option value="{{ $g->id }}" {{ old('group2', $item->group2) == $g->id ? 'selected' : '' }}>{{ $g->gname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- الصور --}}
                        <div class="box">
                            <label class="form-label fw-bold">صور الصنف</label>
                            
                            {{-- عرض الصور الحالية --}}
                            @php
                                $currentImages = DB::table('imgs')
                                    ->where('itemid', $item->id)
                                    ->where('isdeleted', 0)
                                    ->get();
                            @endphp
                            
                            @if($currentImages->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label text-muted">الصور الحالية:</label>
                                    <div class="row g-2" id="current-images">
                                        @foreach($currentImages as $img)
                                            <div class="col-md-2 col-sm-3 col-4" id="image-{{ $img->id }}">
                                                <div class="position-relative">
                                                    <img src="{{ asset('uploads/' . $img->iname) }}" 
                                                         class="img-thumbnail w-100" 
                                                         style="height: 120px; object-fit: cover;"
                                                         onerror="this.src='{{ asset('images/no-image.png') }}'">
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-image" 
                                                            data-image-id="{{ $img->id }}"
                                                            style="padding: 2px 6px; font-size: 12px;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    لا توجد صور لهذا الصنف حالياً
                                </div>
                            @endif
                            
                            {{-- رفع صور جديدة --}}
                            <div class="mb-3">
                                <label for="images" class="form-label">إضافة صور جديدة</label>
                                <input class="form-control" type="file" id="images" name="imgs[]" accept="image/*" multiple>
                                <small class="text-muted">يمكنك اختيار عدة صور (jpg, png, gif, jpeg, webp)</small>
                            </div>
                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer bg-white d-flex justify-content-between">
                        <small class="text-muted">الحقول الأساسية مطلوبة</small>
                        <button class="btn btn-success px-4">تحديث</button>
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

            // Delete image via AJAX
            $(document).on('click', '.delete-image', function(e) {
                e.preventDefault();
                
                if (!confirm('هل تريد حذف هذه الصورة؟')) {
                    return;
                }
                
                var button = $(this);
                var imageId = button.data('image-id');
                var imageContainer = $('#image-' + imageId);
                
                // Disable button during request
                button.prop('disabled', true);
                
                $.ajax({
                    url: '{{ route("items.delete-image") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        image_id: imageId
                    },
                    success: function(response) {
                        if (response.success) {
                            imageContainer.fadeOut(300, function() {
                                $(this).remove();
                                
                                // Check if no more images
                                if ($('#current-images .col-md-2').length === 0) {
                                    $('#current-images').parent().html(
                                        '<div class="alert alert-info mb-3">' +
                                        '<i class="fas fa-info-circle me-2"></i>' +
                                        'لا توجد صور لهذا الصنف حالياً' +
                                        '</div>'
                                    );
                                }
                            });
                        } else {
                            alert(response.message || 'حدث خطأ أثناء حذف الصورة');
                            button.prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        alert('حدث خطأ أثناء حذف الصورة');
                        console.error(xhr);
                        button.prop('disabled', false);
                    }
                });
            });

        });
    </script>
@endsection