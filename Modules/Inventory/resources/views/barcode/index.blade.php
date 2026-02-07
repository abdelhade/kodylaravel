@extends('dashboard.layout')

@section('content')
    <div class="container p-5">
        <div class="card">
            <div class="card-header bg-gradient-to-r from-zinc-50 to-sky-100">
                <h3 class="cake cake-headShake text-center">عرض سعر الصنف بالباركود</h3>
            </div>

            <div class="card-body">
                <div class="text-center">
                    <input type="text" name="iname" id="searchItem"
                        class="form form-control blocked text-center selected"
                        placeholder="امسح الباركود هنا" autofocus>
                    <br>
                    <p id="itemName"  style="font-size: 30px;" class="text-secondary">اسم الصنف</p>
                    <p id="itemPrice" style="font-size: 30px;"  class="text-secondary ">0000</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchItem').on('change keypress', function(e) {
                if (e.type === 'keypress' && e.which !== 13) return;

                let barcode = $(this).val();
                if (!barcode) return;

                // استخدام دالة route() لجلب الرابط تلقائياً
                $.getJSON(@json(route('barcode.price.public')), {
                    barcode: barcode
                }, function(data) {
                    let $price = $('#itemPrice');
                    let $iname = $('#itemName');

                    $iname.text(data.iname).removeClass('cake cake-headShake');
                    $price.text(data.price1).removeClass('cake cake-bounce');

                    setTimeout(function() {
                        $price.addClass('cake cake-bounce');
                        $iname.addClass('cake cake-headShake');
                    }, 10);
                });

                $(this).val('').focus();
            });
        });
    </script>
@endsection
