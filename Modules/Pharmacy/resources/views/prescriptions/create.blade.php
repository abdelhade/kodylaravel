@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form id="validate_form" role="form" action="{{ route('prescriptions.store', ['id' => $client->id]) }}" method="POST">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">إضافة وصفة طبية - {{ $client->name }}</h3>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="analyses">التحاليل المطلوبة</label>
                            <textarea name="analyses" id="analyses" class="form-control" rows="3" placeholder="أدخل التحاليل المطلوبة">{{ old('analyses') }}</textarea>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>الأدوية</h4>
                            </div>
                            <div class="card-body">
                                <div id="drugs-container">
                                    <div class="row drug-row mb-2">
                                        <div class="col-md-5">
                                            <select name="drug[]" class="form-control drug-select" required>
                                                <option value="">اختر دواء</option>
                                                @foreach($drugs as $drug)
                                                    <option value="{{ $drug->id }}">{{ $drug->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="dose[]" class="form-control" placeholder="الجرعة (مثال: 3 مرات يومياً)" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-drug-row">X</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-info" id="add-drug-row">+ إضافة دواء</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">حفظ الوصفة</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('native/dist/js/parsley.js') }}"></script>
<script>
$(document).ready(function() {
    $("#validate_form").parsley();
    
    var drugOptions = @json($drugs->map(function($d) {
        return ['id' => $d->id, 'name' => $d->name];
    }));
    
    function getDrugOptionsHtml() {
        var html = '<option value="">اختر دواء</option>';
        drugOptions.forEach(function(drug) {
            html += '<option value="' + drug.id + '">' + drug.name + '</option>';
        });
        return html;
    }
    
    $("#add-drug-row").click(function() {
        var newRow = `
            <div class="row drug-row mb-2">
                <div class="col-md-5">
                    <select name="drug[]" class="form-control drug-select" required>
                        ${getDrugOptionsHtml()}
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="dose[]" class="form-control" placeholder="الجرعة" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-drug-row">X</button>
                </div>
            </div>
        `;
        $("#drugs-container").append(newRow);
    });
    
    $(document).on("click", ".remove-drug-row", function() {
        if ($(".drug-row").length > 1) {
            $(this).closest(".drug-row").remove();
        } else {
            alert("يجب أن يكون هناك دواء واحد على الأقل");
        }
    });
});
</script>
@endsection
