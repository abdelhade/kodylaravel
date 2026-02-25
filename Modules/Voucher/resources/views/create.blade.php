@extends('dashboard.layout')

@section('content')
<div class="container-fluid p-2">
    <div class="row justify-content-center ">
        <div class="col-10">
            <div class="card {{ $voucher_type == 'recive' ? 'card-success' : 'card-danger' }}">
                <div class="card-header ">
                    <h3 class="card-title text-dark">
                        <i class="fas {{ $voucher_type == 'recive' ? 'fa-hand-holding-usd' : 'fa-money-check-alt' }}"></i>
                        @if($voucher_type == 'recive')
                            سند قبض
                        @else
                            سند دفع
                        @endif
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('voucher.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right"></i> عوده
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('voucher.store') }}" method="POST" id="voucherForm">
                    @csrf
                    <input type="hidden" name="tybe" value="{{ $pro_tybe }}">
                    
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="icon fas fa-ban"></i> {{ session('error') }}
                            </div>
                        @endif
                        
                        <!-- معلومات السند الأساسية -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="voucher_id">
                                        <i class="fas fa-hashtag text-primary"></i> رقم السند
                                    </label>
                                    <input type="text" name="voucher_id" class="form-control form-control-lg" 
                                           value="{{ $next_voucher_id }}" required readonly
                                           style="font-weight: bold; font-size: 1.2rem;">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vdate">
                                        <i class="fas fa-calendar-alt text-info"></i> التاريخ
                                    </label>
                                    <input type="date" name="vdate" class="form-control form-control-lg" 
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="val">
                                        <i class="fas fa-money-bill-wave {{ $voucher_type == 'recive' ? 'text-success' : 'text-danger' }}"></i> 
                                        المبلغ
                                    </label>
                                    <input type="number" step="0.01" name="val" id="val"
                                           class="form-control form-control-lg" required
                                           placeholder="0.00"
                                           style="font-weight: bold; font-size: 1.3rem; text-align: center;">
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- الحسابات -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account">
                                        <i class="fas fa-user-circle text-primary"></i> 
                                        @if($voucher_type == 'recive')
                                            العميل / الحساب
                                        @else
                                            المورد / الحساب
                                        @endif
                                    </label>
                                    <select name="account" id="account" class="form-control select2" required>
                                        <option value="">-- اختر الحساب --</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}">
                                                {{ $account->code }} - {{ $account->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fund_account">
                                        <i class="fas fa-wallet text-warning"></i> الصندوق / البنك
                                    </label>
                                    <select name="fund_account" id="fund_account" class="form-control select2" required>
                                        @foreach($fund_accounts as $fund)
                                            <option value="{{ $fund->id }}">
                                                {{ $fund->code }} - {{ $fund->aname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- مركز التكلفة والملاحظات -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cost_center">
                                        <i class="fas fa-sitemap text-secondary"></i> مركز التكلفة
                                    </label>
                                    <select name="cost_center" class="form-control">
                                        <option value="">-- بدون مركز تكلفة --</option>
                                        @foreach($cost_centers as $center)
                                            <option value="{{ $center->id }}">{{ $center->cname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="info">
                                        <i class="fas fa-comment-alt text-info"></i> البيان / الملاحظات
                                    </label>
                                    <textarea name="info" id="info" class="form-control" rows="2" 
                                              placeholder="أدخل تفاصيل السند..."></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ملخص السند -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="callout callout-{{ $voucher_type == 'recive' ? 'success' : 'danger' }}">
                                    <h5>
                                        <i class="fas fa-info-circle"></i> ملخص السند
                                    </h5>
                                    <p class="mb-0">
                                        @if($voucher_type == 'recive')
                                            <strong>سند قبض:</strong> استلام مبلغ من العميل/الحساب وإيداعه في الصندوق/البنك
                                        @else
                                            <strong>سند دفع:</strong> صرف مبلغ من الصندوق/البنك إلى المورد/الحساب
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-{{ $voucher_type == 'recive' ? 'success' : 'danger' }} btn-lg btn-block" id="submitBtn">
                                    <i class="fas fa-save"></i> حفظ السند
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="reset" class="btn btn-secondary btn-lg btn-block">
                                    <i class="fas fa-redo"></i> إعادة تعيين
                                </button>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('voucher.index') }}" class="btn btn-default btn-lg btn-block">
                                    <i class="fas fa-times"></i> إلغاء
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    
    #val {
        border: 2px solid {{ $voucher_type == 'recive' ? '#28a745' : '#dc3545' }};
    }
    
    #val:focus {
        border-color: {{ $voucher_type == 'recive' ? '#28a745' : '#dc3545' }};
        box-shadow: 0 0 0 0.2rem {{ $voucher_type == 'recive' ? 'rgba(40, 167, 69, 0.25)' : 'rgba(220, 53, 69, 0.25)' }};
    }
</style>

<script>
$(document).ready(function() {
    // تفعيل Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        language: {
            noResults: function() {
                return "لا توجد نتائج";
            },
            searching: function() {
                return "جاري البحث...";
            }
        }
    });
    
    // التركيز على حقل المبلغ
    $('#val').focus();
    
    // F12 للحفظ
    $(document).keydown(function(e) {
        if(e.which == 123) {
            e.preventDefault();
            $('#voucherForm').submit();
        }
    });
    
    // تنسيق المبلغ
    $('#val').on('input', function() {
        let val = $(this).val();
        if(val > 0) {
            $('#submitBtn').prop('disabled', false);
        } else {
            $('#submitBtn').prop('disabled', true);
        }
    });
    
    // تعطيل زر الحفظ في البداية
    $('#submitBtn').prop('disabled', true);
});
</script>
@endsection
