@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h2>استيراد الملفات</h2>
            <div class="card card-secondary">
                <div class="card-header">الخطوة الأولى</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('errors') && is_array(session('errors')))
                        <div class="alert alert-warning">
                            <strong>تحذيرات:</strong>
                            <ul class="mb-0">
                                @foreach(array_slice(session('errors'), 0, 10) as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('import-fp-log.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <p>يمكنك تحميل ملفات Excel فقط (xlsx)</p>
                            <label for="sheet">اختر الملف</label>
                            <input required class="form-control" type="file" name="sheet" id="sheet" accept=".xlsx">
                            <small class="form-text text-muted">الحد الأقصى لحجم الملف: 20 ميجابايت</small>
                        </div>
                        <div class="form-group">
                            <label for="basma_model">نوع الجهاز</label>
                            <select required class="form-control" name="basma_model" id="basma_model">
                                <option value="zkt">zkteco</option>
                                <option value="advision">advision</option>
                                <option value="hikvision">hikvision</option>
                            </select>
                        </div>
                        <button class="form-control btn btn-info" type="submit">تحميل</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
