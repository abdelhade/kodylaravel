@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col"><h1>حجز جديد</h1></div>
                        <div class="col"><a href="{{ route('reservations.index') }}" class="text-sky-500 float-right">كل الحجوزات</a></div>
                    </div>
                </div>
                <form id="validate_form" action="{{ route('reservations.store') }}" method="POST">
                    @csrf
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

                        <div class="row">
                            <div class="col-lg-12">
                                <label for="client">الاسم</label>
                                <div class="input-group">
                                    <input name="client" required list="clientslist" id="client" type="text" class="form-control" value="{{ old('client') }}">
                                    <datalist id="clientslist">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->name }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="date">التاريخ</label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="rentable">القابل للتأجير</label>
                                    <select name="rentable" id="rentable" class="form-control" required>
                                        <option value="">اختر</option>
                                        @foreach($rentables as $rentable)
                                            <option value="{{ $rentable->id }}" {{ old('rentable') == $rentable->id ? 'selected' : '' }}>
                                                {{ $rentable->code }} - {{ $rentable->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="info">معلومات</label>
                                    <textarea name="info" class="form-control" rows="4">{{ old('info') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
