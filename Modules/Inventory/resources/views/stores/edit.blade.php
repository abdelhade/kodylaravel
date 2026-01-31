@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4"><h3>تعديل المخزن</h3></div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 text-right"></div>
                    </div>
                </div>

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

                        <div class="row">
                            <div class="col-lg-2">
                                <button class="btn btn-primary" type="submit">حفظ F12</button>
                                <a href="{{ route('stores.index') }}" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

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
