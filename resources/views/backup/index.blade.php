@extends('dashboard.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-database me-2"></i>
                        النسخ الاحتياطية
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <button id="createBackup" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>
                            إنشاء نسخة احتياطية جديدة
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>اسم الملف</th>
                                    <th>الحجم</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="backupList">
                                @forelse($backups as $backup)
                                <tr>
                                    <td>{{ $backup['name'] }}</td>
                                    <td>{{ $backup['size'] }}</td>
                                    <td>{{ $backup['date'] }}</td>
                                    <td>
                                        <a href="{{ route('backup.download', $backup['name']) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-download"></i> تحميل
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">لا توجد نسخ احتياطية</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#createBackup").click(function(){
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>جاري الإنشاء...');
        
        $.ajax({
            url: "{{ route('backup') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response){
                if(response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert("هناك خطأ ما: " + response.message);
                }
                $("#createBackup").prop('disabled', false).html('<i class="fas fa-plus me-2"></i>إنشاء نسخة احتياطية جديدة');
            },
            error: function(xhr, status, error){
                alert("هناك خطأ ما");
                $("#createBackup").prop('disabled', false).html('<i class="fas fa-plus me-2"></i>إنشاء نسخة احتياطية جديدة');
            }
        });
    });
});
</script>
@endsection
