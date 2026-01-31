@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3>إدخال الوحدات</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('units.store') }}" method="post" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <label for="uname">الوحدة</label>
                                <input type="text" class="form-control" name="uname" id="uname" 
                                       pattern=".{3,}" title="يجب أن يكون الاسم 3 أحرف على الأقل" 
                                       value="{{ old('uname') }}" required>
                                @error('uname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <br>
                                <button type="submit" class="btn btn-primary">حفظ F12</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-4" id="horsTable">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الوحدة</th>
                                    <th>تعديل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($units as $unit)
                                    <tr>
                                        <form action="{{ route('units.update', ['id' => $unit->id]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <th>{{ $unit->id }}</th>
                                            <th>
                                                <input type="text" name="uname" class="form-control" value="{{ $unit->uname }}" required>
                                            </th>
                                            <th>
                                                <button type="submit" class="btn btn-warning">تعديل</button>
                                            </th>
                                        </form>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">لا توجد وحدات</td>
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
