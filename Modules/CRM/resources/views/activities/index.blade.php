@extends('dashboard.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>قائمة الأنشطة</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route('activities.create') }}" class="btn btn-large btn-primary">
                                إضافة نشاط جديد
                            </a>
                        </h3>
                    </div>
                    <div class="card-body table-responsive">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>العنوان</th>
                                    <th>النوع</th>
                                    <th>متعلق بـ</th>
                                    <th>تاريخ النشاط</th>
                                    <th>المدة (دقيقة)</th>
                                    <th>الحالة</th>
                                    <th>عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $index => $activity)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $activity->title }}</td>
                                        <td>{{ $activity->type_name }}</td>
                                        <td>
                                            @if($activity->related_to == 'lead')
                                                عميل محتمل
                                            @elseif($activity->related_to == 'contact')
                                                جهة اتصال
                                            @else
                                                فرصة
                                            @endif
                                        </td>
                                        <td>{{ $activity->activity_date }}</td>
                                        <td>{{ $activity->duration }}</td>
                                        <td>
                                            @if($activity->status == 'planned')
                                                <span class="badge bg-warning">مخطط</span>
                                            @elseif($activity->status == 'completed')
                                                <span class="badge bg-success">مكتمل</span>
                                            @else
                                                <span class="badge bg-danger">ملغي</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{ route('activities.edit') }}?id={{ $activity->id }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('activities.destroy') }}?id={{ $activity->id }}" method="post" style="display: inline-block;" onsubmit="return confirm('هل تريد بالتأكيد حذف {{ $activity->title }}؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
