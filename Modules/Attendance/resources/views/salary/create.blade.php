@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <h2>معالجة البصمة لموظف واحد</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('salary.calculate') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="employee">اسم الموظف</label>
                                            <select required class="form-control" name="employee" id="employee">
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="startdate">من</label>
                                            <input required class="form-control" type="date" name="startdate" id="startdate" value="{{ old('startdate') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="enddate">إلى</label>
                                            <input required class="form-control" type="date" name="enddate" id="enddate" value="{{ old('enddate') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">معالجة</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <form action="{{ route('salary.calculate-group') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="department">الإدارة</label>
                                            <select required class="form-control" name="department" id="department">
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="startdate">من</label>
                                            <input required class="form-control" type="date" name="startdate" id="startdate2" value="{{ old('startdate') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="enddate">إلى</label>
                                            <input required class="form-control" type="date" name="enddate" id="enddate2" value="{{ old('enddate') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">معالجة</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
