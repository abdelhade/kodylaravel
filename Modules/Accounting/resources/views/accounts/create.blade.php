@extends('layouts.master')

@section('content')
@php
    $mainColor = $context['color'] ?? 'slate';
    $mainIcon = $context['icon'] ?? 'fa-plus-circle';
    $pageTitle = $context['name'] ?? 'دليل الحسابات';
    
    $colorMap = [
        'azure' => ['bg' => '#f0f7ff', 'border' => '#bee3f8', 'text' => '#2b6cb0', 'btn' => '#3182ce', 'btnHover' => '#2c5282', 'btnLight' => '#dbeafe', 'accent' => '#93c5fd'],
        'indigo' => ['bg' => '#f5f3ff', 'border' => '#ddd6fe', 'text' => '#5b21b6', 'btn' => '#7c3aed', 'btnHover' => '#6d28d9', 'btnLight' => '#ede9fe', 'accent' => '#a78bfa'],
        'emerald' => ['bg' => '#ecfdf5', 'border' => '#a7f3d0', 'text' => '#065f46', 'btn' => '#10b981', 'btnHover' => '#059669', 'btnLight' => '#d1fae5', 'accent' => '#6ee7b7'],
        'blue' => ['bg' => '#eff6ff', 'border' => '#bfdbfe', 'text' => '#1e40af', 'btn' => '#3b82f6', 'btnHover' => '#2563eb', 'btnLight' => '#dbeafe', 'accent' => '#93c5fd'],
        'rose' => ['bg' => '#fff1f2', 'border' => '#fecdd3', 'text' => '#9f1239', 'btn' => '#f43f5e', 'btnHover' => '#e11d48', 'btnLight' => '#ffe4e6', 'accent' => '#fb7185'],
        'amber' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#92400e', 'btn' => '#f59e0b', 'btnHover' => '#d97706', 'btnLight' => '#fef3c7', 'accent' => '#fcd34d'],
        'orange' => ['bg' => '#fff7ed', 'border' => '#fed7aa', 'text' => '#9a3412', 'btn' => '#f97316', 'btnHover' => '#ea580c', 'btnLight' => '#ffedd5', 'accent' => '#fb923c'],
        'slate' => ['bg' => '#f8fafc', 'border' => '#e2e8f0', 'text' => '#1e293b', 'btn' => '#475569', 'btnHover' => '#334155', 'btnLight' => '#f1f5f9', 'accent' => '#94a3b8'],
    ];
    
    $theme = $colorMap[$mainColor] ?? $colorMap['slate'];
@endphp

<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --clr-primary: {{ $theme['btn'] }};
        --clr-primary-hover: {{ $theme['btnHover'] }};
        --clr-primary-light: {{ $theme['btnLight'] }};
        --clr-primary-text: {{ $theme['text'] }};
        --clr-accent: {{ $theme['accent'] }};
        --clr-border: {{ $theme['border'] }};
        --clr-bg: {{ $theme['bg'] }};

        --clr-surface: #ffffff;
        --clr-surface-alt: #f8fafc;
        --clr-text-main: #0f172a;
        --clr-text-muted: #64748b;
        --clr-text-placeholder: #94a3b8;
        --clr-input-border: #e2e8f0;
        --clr-shadow: rgba(15, 23, 42, 0.06);

        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;

        --transition: 0.25s cubic-bezier(.4,0,.2,1);
    }

    * { box-sizing: border-box; }

    .page-wrap {
        font-family: 'IBM Plex Sans Arabic', sans-serif;
        direction: rtl;
        min-height: 100vh;
        background: var(--clr-surface-alt);
        background-image:
            radial-gradient(ellipse 80% 50% at 20% 0%, var(--clr-primary-light) 0%, transparent 60%),
            radial-gradient(ellipse 60% 40% at 85% 100%, var(--clr-primary-light) 0%, transparent 55%);
        padding: 28px 0px;
        animation: fadeIn .5s ease;
    }

    @keyframes fadeIn { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }

    /* ─── Header Strip ─── */
    .page-header {
        max-width: 860px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .header-icon-wrap {
        width: 56px; height: 56px;
        border-radius: var(--radius-lg);
        background: linear-gradient(135deg, var(--clr-primary), var(--clr-primary-hover));
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 18px color-mix(in srgb, var(--clr-primary) 35%, transparent);
        flex-shrink: 0;
    }
    .header-icon-wrap i { color: #fff; font-size: 1.5rem; }

    .header-text h1 {
        font-size: 1.45rem;
        font-weight: 700;
        color: var(--clr-text-main);
        margin: 0 0 2px;
        letter-spacing: -.3px;
    }
    .header-text p {
        font-size: .88rem;
        color: var(--clr-text-muted);
        margin: 0;
    }
    .header-text p span {
        color: var(--clr-primary);
        font-weight: 600;
    }

    /* ─── Card ─── */
    .form-card {
        max-width: 860px;
        margin: 0 auto;
        background: var(--clr-surface);
        border-radius: var(--radius-xl);
        border: 1px solid #eef2f7;
        box-shadow: 0 8px 40px var(--clr-shadow);
        overflow: hidden;
        animation: cardUp .45s .08s cubic-bezier(.4,0,.2,1) both;
    }
    @keyframes cardUp { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:translateY(0); } }

    /* colored top bar */
    .card-top-bar {
        height: 5px;
        background: linear-gradient(90deg, var(--clr-primary), var(--clr-accent), var(--clr-primary-hover));
    }

    .form-body { padding: 28px; }

    /* ─── Section Label ─── */
    .section-label {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--clr-text-muted);
        margin-bottom: 18px;
        margin-top: 32px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-label:first-child { margin-top: 0; }
    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--clr-input-border);
    }

    /* ─── Grid Row ─── */
    .form-row {
        display: grid;
        gap: 20px;
        margin-bottom: 20px;
    }
    .form-row.col-1-2  { grid-template-columns: 1fr 2fr; }
    .form-row.col-half { grid-template-columns: 1fr 1fr; }

    /* ─── Field ─── */
    .field { display: flex; flex-direction: column; }

    .field label {
        font-size: .88rem;
        font-weight: 600;
        color: var(--clr-text-main);
        margin-bottom: 7px;
    }
    .field label .req {
        color: var(--clr-primary);
        margin-left: 3px;
    }

    .input-wrap { position: relative; }

    .field input,
    .field select {
        width: 100%;
        font-family: inherit;
        font-size: .95rem;
        color: var(--clr-text-main);
        background: var(--clr-surface-alt);
        border: 1.5px solid var(--clr-input-border);
        border-radius: var(--radius-md);
        transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
        appearance: none;
        -webkit-appearance: none;
        outline: none;
    }

    .field input::placeholder { color: var(--clr-text-placeholder); }

    .field input:focus,
    .field select:focus {
        border-color: var(--clr-primary);
        background: #fff;
        box-shadow: 0 0 0 3.5px var(--clr-primary-light);
    }

    .field input[readonly] {
        background: var(--clr-primary-light);
        border-color: var(--clr-border);
        color: var(--clr-primary-text);
        font-weight: 600;
        cursor: not-allowed;
    }

    /* select arrow */
    .select-wrap { position: relative; }
    .select-wrap::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: .72rem;
        color: var(--clr-text-muted);
        position: absolute;
        left: 16px; top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
    .select-wrap select { padding-left: 38px; }

    /* ─── Name Check Result ─── */
    #check-result {
        font-size: .82rem;
        margin-top: 5px;
        min-height: 18px;
        font-weight: 500;
    }

    /* ─── Validation errors ─── */
    .field .err-msg {
        font-size: .8rem;
        color: #e53e3e;
        margin-top: 5px;
        font-weight: 500;
    }
    .field input.is-invalid,
    .field select.is-invalid {
        border-color: #e53e3e;
    }
    .field input.is-invalid:focus,
    .field select.is-invalid:focus {
        box-shadow: 0 0 0 3.5px rgba(229,62,62,.15);
    }

    /* ─── Features Panel ─── */
    .features-panel {
        background: linear-gradient(135deg, var(--clr-bg), var(--clr-surface-alt));
        border: 1.5px solid var(--clr-border);
        border-radius: var(--radius-lg);
        padding: 22px 24px;
        margin-top: 8px;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,.7);
        border: 1px solid transparent;
        border-radius: var(--radius-md);
        padding: 12px 14px;
        transition: all var(--transition);
        cursor: pointer;
    }
    .feature-item:hover {
        border-color: var(--clr-border);
        background: #fff;
        box-shadow: 0 2px 8px var(--clr-shadow);
    }
    .feature-item input[type=checkbox] {
        width: 19px; height: 19px;
        accent-color: var(--clr-primary);
        cursor: pointer;
        flex-shrink: 0;
    }
    .feature-item span {
        font-size: .9rem;
        font-weight: 500;
        color: var(--clr-text-main);
        user-select: none;
    }
    .feature-item .feat-icon {
        font-size: .95rem;
        color: var(--clr-primary);
        width: 20px;
        text-align: center;
        flex-shrink: 0;
    }

    /* ─── Buttons ─── */
    .btn-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-top: 36px;
        max-width: 560px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-primary, .btn-ghost {
        font-family: inherit;
        font-size: .95rem;
        font-weight: 700;
        border: none;
        border-radius: var(--radius-md);
        padding: 13px 20px;
        cursor: pointer;
        transition: all var(--transition);
        text-decoration: none;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--clr-primary), var(--clr-primary-hover));
        color: #fff;
        box-shadow: 0 4px 14px color-mix(in srgb, var(--clr-primary) 40%, transparent);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px color-mix(in srgb, var(--clr-primary) 45%, transparent);
    }
    .btn-primary:active { transform: translateY(0); }

    .btn-ghost {
        background: var(--clr-surface-alt);
        color: var(--clr-text-muted);
        border: 1.5px solid var(--clr-input-border);
    }
    .btn-ghost:hover {
        background: #eef2f7;
        color: var(--clr-text-main);
        border-color: #cbd5e1;
    }

    /* ─── Responsive ─── */
    @media (max-width: 640px) {
        .page-wrap { padding: 28px 16px; }
        .form-body { padding: 24px 20px 28px; }
        .form-row.col-1-2,
        .form-row.col-half { grid-template-columns: 1fr; }
        .features-grid { grid-template-columns: 1fr 1fr; }
        .btn-row { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; text-align: center; }
    }
</style>


<div class="page-wrap">

    <!-- Header -->
    <div class="page-header">
        <div class="header-icon-wrap">
            <i class="fas {{ $mainIcon }}"></i>
        </div>
        <div class="header-text">
            <h1>إضافة حساب جديد</h1>
            <p>دليل: <span>{{ $pageTitle }}</span></p>
        </div>
    </div>

    <!-- Card -->
    <div class="form-card">
        <div class="form-body">

            <form action="{{ route('accounts.store', ['acc' => $accType]) }}" method="POST">
                @csrf

                <!-- ── Basic Info ── -->
                <div class="section-label"><i class="fas fa-id-card"></i>&nbsp; البيانات الأساسية</div>

                <div class="form-row col-1-2">
                    <!-- Code -->
                    <div class="field">
                        <label for="code">الكود الرقمي <span class="req">*</span></label>
                        <input type="text" name="code" id="code"
                               class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code', $lastId) }}"
                               placeholder="كود"
                               required
                               {{ $accType ? 'readonly' : '' }}>
                        @error('code')<div class="err-msg">{{ $message }}</div>@enderror
                    </div>

                    <!-- Name -->
                    <div class="field">
                        <label for="aname">اسم الحساب / الجهة <span class="req">*</span></label>
                        <div class="input-wrap">
                            <input type="text" name="aname" id="aname"
                                   class="form-control @error('aname') is-invalid @enderror"
                                   value="{{ old('aname') }}"
                                   placeholder="الاسم الكامل للجهة"
                                   required
                                   onkeyup="checkAccountName(this.value)">
                        </div>
                        <div id="check-result"></div>
                        @error('aname')<div class="err-msg">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- ── Hierarchy ── -->
                <div class="section-label"><i class="fas fa-sitemap"></i>&nbsp; التصنيف والنوع</div>

                <div class="form-row col-half">
                    <!-- Parent -->
                    <div class="field">
                        <label for="parent_id">الحساب الأب <span class="req">*</span></label>
                        <div class="select-wrap">
                            <select name="parent_id" id="parent_id"
                                    class="form-control @error('parent_id') is-invalid @enderror"
                                    required>
                                @foreach($parentAccounts as $pAcc)
                                    <option value="{{ $pAcc->id }}" {{ $parent == $pAcc->code ? 'selected' : '' }}>
                                        {{ $pAcc->code }} – {{ $pAcc->aname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('parent_id')<div class="err-msg">{{ $message }}</div>@enderror
                    </div>

                    <!-- Type -->
                    <div class="field">
                        <label for="is_basic">نوع الحساب</label>
                        <div class="select-wrap">
                            <select name="is_basic" id="is_basic" class="form-control">
                                <option value="0" {{ $accType ? 'selected' : '' }}>فرعي – يقبل حركة</option>
                                @if(!$accType)
                                    <option value="1">رئيسي – تجميعي فقط</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ── Contact ── -->
                <div class="section-label"><i class="fas fa-phone-alt"></i>&nbsp; بيانات التواصل</div>

                <div class="form-row col-half">
                    <div class="field">
                        <label for="phone">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="اختياري">
                    </div>
                    <div class="field">
                        <label for="address">العنوان</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" placeholder="اختياري">
                    </div>
                </div>

                <!-- ── Features ── -->
                @if(!$accType)
                <div class="section-label"><i class="fas fa-cog"></i>&nbsp; خصائص الحساب</div>
                <div class="features-panel">
                    <div class="features-grid">
                        <label class="feature-item">
                            <input type="checkbox" name="is_fund" value="1">
                            <span class="feat-icon"><i class="fas fa-piggy-bank"></i></span>
                            <span>صندوق مالي</span>
                        </label>
                        <label class="feature-item">
                            <input type="checkbox" name="rentable" value="1">
                            <span class="feat-icon"><i class="fas fa-key"></i></span>
                            <span>قابل للإيجار</span>
                        </label>
                        <label class="feature-item">
                            <input type="checkbox" name="is_stock" value="1">
                            <span class="feat-icon"><i class="fas fa-boxes"></i></span>
                            <span>مخزن بضاعة</span>
                        </label>
                        <label class="feature-item">
                            <input type="checkbox" name="secret" value="1">
                            <span class="feat-icon"><i class="fas fa-lock"></i></span>
                            <span>حساب سري</span>
                        </label>
                    </div>
                </div>
                @else
                    <input type="hidden" name="is_fund"    value="{{ $accType == 'funds'    ? 1 : 0 }}">
                    <input type="hidden" name="rentable"   value="{{ $accType == 'rentable' ? 1 : 0 }}">
                    <input type="hidden" name="is_stock"   value="{{ $accType == 'stores'   ? 1 : 0 }}">
                @endif

                <!-- ── Buttons ── -->
                <div class="btn-row">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> حفظ كـ {{ $pageTitle }}
                    </button>
                    <a href="{{ route('accounts.index', ['acc' => $accType]) }}" class="btn-ghost">
                        <i class="fas fa-arrow-right"></i> إلغاء
                    </a>
                </div>
            </form>

        </div><!-- /form-body -->
    </div><!-- /form-card -->
</div><!-- /page-wrap -->

<!-- ═══════════════════════════════════════════════ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function checkAccountName(val) {
    if (val.length < 3) {
        $("#check-result").html('');
        return;
    }
    $.get("{{ route('accounts.check-name') }}", { id: val }, function(data) {
        $("#check-result").html(data.message);
    });
}
</script>
@endsection