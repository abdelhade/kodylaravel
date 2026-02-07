@extends('dashboard.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">تعديل المخزن</h3>
                <small class="text-muted">تحديث بيانات المخزن الحالي</small>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('stores.update', ['id' => $store->id]) }}" method="post" id="myForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-2 bg-light">
                                اسم المخزن
                            </div>
                            <div class="col-lg-4">
                                <input type="text" name="store" id="store" class="form-control form-control-sm" value="{{ old('store', $store->aname) }}" required>
                                @error('store')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-save me-1"></i> حفظ (F12)
                                </button>
                                <a href="{{ route('stores.index') }}" class="btn btn-outline-secondary ms-2">إلغاء</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // F12 shortcut to submit form
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F12') {
            e.preventDefault();
            document.getElementById('myForm').submit();
        }
    });
});
</script>
@endsection
