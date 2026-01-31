@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form action="{{ route('vouchers.store') }}" method="post" id="myForm">
                @csrf
                <input type="hidden" name="tybe" value="{{ $proType }}">
                <div class="card card-primary {{ isset($edit) ? 'card-warning' : '' }}">
                    <div class="card-header">
                        <h3>
                            @if($type == 'recive')
                                سند قبض
                            @else
                                سند دفع
                            @endif
                        </h3>
                    </div>
                    <div class="card-body bg-dark">
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
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="voucher_id">الرقم</label>
                                    <input type="text" name="voucher_id" class="form-control" id="voucher_id" value="{{ old('voucher_id', $nextId) }}" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="vdate">التاريخ</label>
                                    <input type="date" name="vdate" class="form-control" value="{{ old('vdate', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="acc1">
                                        @if($type == 'recive')
                                            من حساب
                                        @else
                                            من حساب
                                        @endif
                                    </label>
                                    <select name="acc1" id="acc1" class="form-control" required>
                                        <option value="">اختر الحساب</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ old('acc1') == $account->id ? 'selected' : '' }}>
                                                {{ $account->code }} - {{ $account->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="acc2">
                                        @if($type == 'recive')
                                            إلى حساب
                                        @else
                                            إلى حساب
                                        @endif
                                    </label>
                                    <select name="acc2" id="acc2" class="form-control" required>
                                        <option value="">اختر الحساب</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ old('acc2') == $account->id ? 'selected' : '' }}>
                                                {{ $account->code }} - {{ $account->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="pro_value">القيمة</label>
                                    <input type="number" name="pro_value" class="form-control" id="pro_value" step="0.01" min="0" value="{{ old('pro_value') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="info">ملاحظات</label>
                                    <textarea name="info" id="info" class="form-control" rows="3">{{ old('info') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="{{ route('vouchers.index', ['t' => $type]) }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
