@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('settings.index') }}" method="post">
                                @csrf
                                <center>
                                    <h3>كلمة المرور</h3>
                                    @if(isset($error))
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endif
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="password" id="password" required autofocus>
                                    </div>
                                    <button type="submit" class="btn btn-danger">تم</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
