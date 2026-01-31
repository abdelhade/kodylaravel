@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form action="{{ route('calls.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="hadi-wonder">مكالمة جديدة</h3>
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
                            <div class="form-group col-lg-3">
                                <label for="subject">الموضوع</label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="اكتب أي اسم مرجعي" value="{{ old('subject') }}" required>
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="client_id">العميل</label>
                                <select name="client_id" id="client_id" class="form-control" required>
                                    <option value="">اختر العميل</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->aname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="call_type">نوع المكالمة</label>
                                <select name="call_type" id="call_type" class="form-control" required>
                                    <option value="1" {{ old('call_type', '1') == '1' ? 'selected' : '' }}>وارد</option>
                                    <option value="0" {{ old('call_type') == '0' ? 'selected' : '' }}>صادر</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label for="call_date">تاريخ المكالمة</label>
                                <input type="date" class="form-control" name="call_date" id="call_date" value="{{ old('call_date', date('Y-m-d')) }}" required>
                            </div>

                            <div class="form-group col-lg-2">
                                <label for="call_time">وقت المكالمة</label>
                                <input type="time" class="form-control" name="call_time" id="call_time" value="{{ old('call_time', date('H:i')) }}" required>
                            </div>

                            <div class="form-group col-lg-1">
                                <label for="duration">مدة المكالمة</label>
                                <input type="text" class="form-control bg-light" name="duration" id="duration" placeholder="00:00" value="{{ old('duration') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="emp_comment">تعليق الموظف</label>
                                <input type="text" class="form-control" name="emp_comment" id="emp_comment" placeholder="تعليق الموظف" value="{{ old('emp_comment') }}">
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="content">محتوى المكالمة</label>
                                <textarea name="content" id="content" cols="50" rows="5" class="form-control">{{ old('content') }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="next_date">تاريخ المكالمة القادمة</label>
                                <input type="date" class="form-control" name="next_date" id="next_date" value="{{ old('next_date') }}">
                            </div>

                            <div class="form-group col-lg-2">
                                <label for="next_time">وقت المكالمة القادمة</label>
                                <input type="time" class="form-control" name="next_time" id="next_time" value="{{ old('next_time') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="mod_comment">تعليق المراجع للمكالمات</label>
                                <textarea name="mod_comment" id="mod_comment" cols="50" rows="5" class="form-control">{{ old('mod_comment') }}</textarea>
                            </div>

                            <div class="form-group col-lg-1">
                                <label for="mod_rate">تقييم المراجع</label>
                                <select name="mod_rate" id="mod_rate" class="form-control">
                                    @for($i = 9; $i >= 0; $i--)
                                        <option value="{{ $i }}" {{ old('mod_rate', '5') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">حفظ</button>
                        <a href="{{ route('calls.index') }}" class="btn btn-secondary btn-block">إلغاء</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
