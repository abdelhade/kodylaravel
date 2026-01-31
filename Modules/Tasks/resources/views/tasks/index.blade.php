@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-solid">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h1>المهمات</h1>
                        </div>
                        <div class="col">
                            <form action="{{ route('tasks.index') }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <select name="user" id="userSelect" class="form-control">
                                        <option value="">الكل</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->uname }}" {{ $userFilter == $user->uname ? 'selected' : '' }}>
                                                {{ $user->uname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="input-group-text btn btn-secondary">فلتر</button>
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <a class="btn btn-primary float-right" href="{{ route('tasks.create') }}" id="addNewElement">جديد</a>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="main-card">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row d-flex align-items-stretch">
                        @foreach($tasks as $task)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ $task->name }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>الهاتف:</strong> {{ $task->phone ?? 'غير محدد' }}</p>
                                        <p><strong>المعلومات:</strong> {{ $task->info ?? 'لا توجد معلومات' }}</p>
                                        <p><strong>التاريخ:</strong> {{ $task->crtime ?? $task->created_at }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="btn btn-warning btn-sm">تعديل</a>
                                        <a href="{{ route('tasks.destroy', ['id' => $task->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
