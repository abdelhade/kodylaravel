@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $lang['lang_orders_new'] ?? 'طلب جديد' }}</h3>
                </div>
                <form role="form" action="{{ route('orders.store') }}" method="post">
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

                        <!-- First Row -->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>{{ $lang['lang_choiceemployee'] ?? 'اختر الموظف' }}</label>
                                    <select name="employee" class="custom-select" required>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>{{ $lang['lang_typeOrder'] ?? 'نوع الطلب' }}</label>
                                    <select name="tybe" class="custom-select" required>
                                        @foreach($orderTypes as $orderType)
                                            <option value="{{ $orderType->id }}" {{ old('tybe', $orderTypeId) == $orderType->id ? 'selected' : '' }}>
                                                {{ $orderType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>{{ $lang['lang_StatusOrder'] ?? 'حالة الطلب' }}</label>
                                    <select name="status" class="custom-select" required>
                                        @foreach($orderStatuses as $orderStatus)
                                            <option value="{{ $orderStatus->id }}">{{ $orderStatus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="applyingdate">{{ $lang['lang_Submissiondate'] ?? 'تاريخ التقديم' }}</label>
                                    <input type="date" class="form-control" name="applyingdate" id="applyingdate" value="{{ old('applyingdate', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="curdate">{{ $lang['lang_Startingdate'] ?? 'تاريخ البدء' }}</label>
                                    <input type="date" class="form-control" name="curdate" id="curdate" value="{{ old('curdate') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">{{ $lang['lang_publicconfirm'] ?? 'تأكيد' }}</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
