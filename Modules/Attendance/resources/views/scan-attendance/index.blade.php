@extends('dashboard.layout')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white shadow-md rounded-lg">
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="w-full">
                                <h1>تسجيل حضور بالباركود</h1>
                                <form id="attendanceForm" action="{{ route('scan-attendance.scan') }}" method="post">
                                    @csrf
                                    <input name="employee" type="text" class="form-control frst bg-red-300 focus:bg-orange-300" placeholder="امسح الباركود أو اكتب رقم البصمة" autofocus>
                                    <input type="hidden" name="fptybe" value="1">
                                    <input type="hidden" name="fpdate" id="fpdate" value="{{ date('Y-m-d') }}">
                                    <input type="hidden" name="fptime" id="fptime" value="{{ date('H:i:s') }}">
                                </form>

                                <div class="bg-orange-200 text-orange-700 text-xl min-h-50 p-3 mt-3 rounded" id="message"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Update date and time on page load
    updateDateTime();
    setInterval(updateDateTime, 1000); // Update every second

    function updateDateTime() {
        const now = new Date();
        const date = now.toISOString().split('T')[0];
        const time = now.toTimeString().split(' ')[0];
        $('#fpdate').val(date);
        $('#fptime').val(time);
    }

    $('.frst').keypress(function(event) {
        if (event.which === 13) {  // 13 is the Enter key code
            event.preventDefault();
            submitForm();
        }
    });

    function submitForm() {
        const formData = $('#attendanceForm').serialize();
        
        $.ajax({
            url: $('#attendanceForm').attr('action'),
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#message').removeClass('bg-red-200 text-red-700').addClass('bg-green-200 text-green-700');
                    $('#message').html('<strong>✓</strong> ' + response.message);
                } else {
                    $('#message').removeClass('bg-green-200 text-green-700').addClass('bg-red-200 text-red-700');
                    $('#message').html('<strong>✗</strong> ' + response.message);
                }
                $('.frst').val('').focus();  // Clear the input field after submission
            },
            error: function(xhr) {
                let errorMessage = 'حدث خطأ أثناء التسجيل';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#message').removeClass('bg-green-200 text-green-700').addClass('bg-red-200 text-red-700');
                $('#message').html('<strong>✗</strong> ' + errorMessage);
                $('.frst').val('').focus();
            }
        });
    }
});
</script>
@endsection
