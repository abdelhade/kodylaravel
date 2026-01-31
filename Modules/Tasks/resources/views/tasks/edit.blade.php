@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">{{ $lang['lang_add_task'] ?? 'تعديل مهمة' }}</h3>
                </div>
                <form id="myForm" action="{{ route('tasks.update') }}?id={{ $task->id }}" method="post">
                    @csrf
                    @method('PUT')
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

                        <div class="form-group">
                            <input list="cllist" name="name" type="text" class="form-control" placeholder="{{ $lang['lang_pbholder_client'] ?? 'اسم العميل' }}" value="{{ old('name', $task->name) }}" required>
                            <input name="phone" type="text" class="form-control mt-2" placeholder="{{ $lang['lang_pbholder_phone'] ?? 'التليفون' }}" value="{{ old('phone', $task->phone) }}">
                            <datalist id="cllist">
                                @foreach($clients as $client)
                                    <option value="{{ $client->name }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>{{ $lang['lang_user'] ?? 'المستخدم' }}</label>
                                    <select name="user" class="form-control" required>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user', $task->user) == $user->id ? 'selected' : '' }}>
                                                {{ $user->uname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ $lang['lang_info'] ?? 'معلومات' }}</label>
                            <textarea name="info" class="form-control" rows="4">{{ old('info', $task->info) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">تحديث</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
