@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            @if(isset($role['add_clients']) && $role['add_clients'] == 1)
                <div class="card card-primary">
                    <form action="{{ route('clients.store') }}" method="post">
                        @csrf
                        <div class="card-header">
                            <h3>عميل جديد</h3>
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

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="name">الاسم</label>
                                        <input placeholder="ادخل اسم العميل" class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="phone">phone</label>
                                        <input placeholder="ادخل تليفون" class="form-control" type="text" name="phone" id="phone" value="{{ old('phone') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="town">المدينه</label>
                                    <select class="form-control" name="city" id="city">
                                        @foreach($towns as $town)
                                            <option value="{{ $town->id }}" {{ old('city') == $town->id ? 'selected' : '' }}>{{ $town->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="address">العنوان</label>
                                        <input placeholder="ادخل العنوان" class="form-control" type="text" name="address" id="address" value="{{ old('address') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="gender">gender</label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="0" {{ old('gender') == 0 ? 'selected' : '' }}>ذكر</option>
                                            <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>انثي</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="height">height</label>
                                        <input placeholder="ادخل الطول" class="form-control" type="number" name="height" id="height" value="{{ old('height') }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="weight">weight</label>
                                        <input placeholder="الوزن بالkg" class="form-control" type="number" name="weight" id="weight" value="{{ old('weight') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="dateofbirth">تاريخ الميلاد</label>
                                        <input placeholder="" class="form-control" type="date" name="dateofbirth" id="dateofbirth" value="{{ old('dateofbirth') }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="ref">رقم الرفيق</label>
                                        <input placeholder="ادخل تليفون" class="form-control" type="text" name="ref" id="ref" value="{{ old('ref') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="diseses">امراض مزمنه</label>
                                        <textarea placeholder="ادخل الامراض المزمنه" class="form-control" name="diseses" id="diseses" cols="30" rows="5">{{ old('diseses') }}</textarea>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="info">ملاحظات اخري</label>
                                        <textarea placeholder="ادخل الملاحظات" class="form-control" name="info" id="info" cols="30" rows="5">{{ old('info') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary btn-flat btn-block" type="submit">تأكيد</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-secondary btn-flat btn-block" type="reset">مسح البيانات</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="alert alert-danger">{{ $userErrorMassage ?? 'ليس لديك صلاحية للوصول إلى هذه الصفحة' }}</div>
            @endif
        </div>
    </section>
</div>
@endsection
