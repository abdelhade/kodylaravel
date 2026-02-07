@extends('layouts.master')

@section('content')
    @php
        $mainColor = $context['color'] ?? 'slate';
        $mainIcon = $context['icon'] ?? 'fa-sitemap';
        $pageTitle = $context['name'] ?? 'دليل الحسابات';

        $colorMap = [
            'azure' => [
                'bg' => '#f0f7ff',
                'border' => '#bee3f8',
                'text' => '#2b6cb0',
                'btn' => '#3182ce',
                'btnHover' => '#2c5282',
            ],
            'indigo' => [
                'bg' => '#f5f3ff',
                'border' => '#ddd6fe',
                'text' => '#5b21b6',
                'btn' => '#7c3aed',
                'btnHover' => '#6d28d9',
            ],
            'emerald' => [
                'bg' => '#ecfdf5',
                'border' => '#a7f3d0',
                'text' => '#065f46',
                'btn' => '#10b981',
                'btnHover' => '#059669',
            ],
            'blue' => [
                'bg' => '#eff6ff',
                'border' => '#bfdbfe',
                'text' => '#1e40af',
                'btn' => '#3b82f6',
                'btnHover' => '#2563eb',
            ],
            'rose' => [
                'bg' => '#fff1f2',
                'border' => '#fecdd3',
                'text' => '#9f1239',
                'btn' => '#f43f5e',
                'btnHover' => '#e11d48',
            ],
            'amber' => [
                'bg' => '#fffbeb',
                'border' => '#fde68a',
                'text' => '#92400e',
                'btn' => '#f59e0b',
                'btnHover' => '#d97706',
            ],
            'orange' => [
                'bg' => '#fff7ed',
                'border' => '#fed7aa',
                'text' => '#9a3412',
                'btn' => '#f97316',
                'btnHover' => '#ea580c',
            ],
            'slate' => [
                'bg' => '#f8fafc',
                'border' => '#e2e8f0',
                'text' => '#1e293b',
                'btn' => '#475569',
                'btnHover' => '#334155',
            ],
        ];

        $theme = $colorMap[$mainColor] ?? $colorMap['slate'];
    @endphp

    <style>
        .accounts-container {
            padding: 30px;
            background-color: #f8f9fc;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #eef2f7;
            border-right: 5px solid {{ $theme['btn'] }};
        }

        .page-title {
            color: {{ $theme['text'] }};
            font-weight: 700;
            margin-bottom: 0;
            font-size: 2rem;
        }

        .btn-custom {
            background: {{ $theme['btn'] }};
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-custom:hover {
            background: {{ $theme['btnHover'] }};
            color: white;
            transform: translateY(-2px);
        }

        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #eef2f7;
        }

        .premium-table {
            width: 100%;
            border-collapse: collapse;
        }

        .premium-table thead {
            background-color: #f8f9fc;
        }

        .premium-table th {
            padding: 20px 25px;
            text-align: right;
            font-weight: 700;
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
        }

        .premium-table td class='p-2' {
            padding: 18px 25px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
            color: #4a5568;
            font-size: 1.05rem;
        }

        .premium-table tr:hover {
            background-color: {{ $theme['bg'] }};
        }

        .code-badge {
            background: {{ $theme['bg'] }};
            color: {{ $theme['text'] }};
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-family: monospace;
            border: 1px solid {{ $theme['border'] }};
        }

        .balance-positive {
            color: #059669;
            font-weight: 700;
        }

        .balance-negative {
            color: #dc2626;
            font-weight: 700;
        }

        /* Tree View Styles */
        #tree-container ul {
            list-style: none;
            padding-right: 25px;
        }

        .caret {
            cursor: pointer;
            user-select: none;
            font-size: 1.1rem;
        }

        .caret::before {
            content: "\f0d9";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-left: 8px;
            transition: 0.3s;
            display: inline-block;
        }

        .caret-down::before {
            transform: rotate(-90deg);
        }

        .nested {
            display: none;
            margin-top: 10px;
        }

        .active-node {
            display: block;
        }

        .tree-item {
            padding: 8px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
    </style>

    <div class="accounts-container container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="page-title">
                        <i class="fas {{ $mainIcon }} mr-3"></i> {{ $pageTitle }}
                        @if ($accType)
                            <span class="badge badge-light ml-2 text-muted"
                                style="font-size: 1rem;">{{ $accounts->count() }}</span>
                        @endif
                    </h1>
                </div>
                <div class="col-md-6 d-flex justify-content-end gap-3">
                    <a href="{{ route('accounts.create', ['acc' => $accType]) }}" class="btn-custom">
                        <i class="fas fa-plus"></i> إضافة جديد
                    </a>
                    @if ($accType)
                        <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary"
                            style="border-radius: 10px; padding: 12px 20px;">
                            <i class="fas fa-sitemap"></i> عرض الدليل بالكامل
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        @if (!$accType)
            <!-- General Tree View -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="table-card p-4 mb-4" id="tree-container">
                        <h4 class="mb-4 font-weight-bold">الدليل الشجري</h4>
                        <ul id="myUL">
                            @foreach ($treeAccounts as $account)
                                @include('accounting::accounts.partials.tree-item', [
                                    'account' => $account,
                                    'level' => 0,
                                ])
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
        @endif

        <!-- Accounts Table -->
        <div class="card table-card">
            <div class="card-body overflow-x-auto p-2">
                <div class="table table-responsive table-hover">
                    <table class="premium-table" id="accountsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="120">الكود</th>
                                <th>اسم الحساب</th>
                                @if ($accType)
                                    <th>الرصيد الحالى</th>
                                    <th>التليفون</th>
                                    <th>العنوان</th>
                                @else
                                    <th>النوع</th>
                                    <th>حالة الحساب</th>
                                @endif
                                <th width="150">عمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accounts as $account)
                                <tr class="p-2">
                                    <td class='p-2'>{{ $account->id }}</td>
                                    <td class='p-2'><span class="code-badge">{{ $account->code }}</span></td
                                        class='p-2'>
                                    <td class='p-2'>
                                        <strong class="text-dark">{{ $account->aname }}</strong>
                                        @if (!$accType && $account->is_basic)
                                            <span class="badge badge-secondary ml-1">رئيسي</span>
                                        @endif
                                    </td>

                                    @if ($accType)
                                        <td class='p-2'>
                                            <span
                                                class="{{ ($account->balance ?? 0) >= 0 ? 'balance-positive' : 'balance-negative' }}">
                                                {{ number_format($account->balance ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td class='p-2'>{{ $account->phone ?? '-' }}</td>
                                        <td class='p-2'>{{ Str::limit($account->address ?? '-', 30) }}</td
                                            class='p-2'>
                                    @else
                                        <td class='p-2'>{{ $account->kind == 1 ? 'ميزانية' : 'أرباح وخسائر' }}</td
                                            class='p-2'>
                                        <td class='p-2'>
                                            @if ($account->is_basic)
                                                <span class="text-muted"><i class="fas fa-folder"></i> تجميعي</span>
                                            @else
                                                <span class="text-success"><i class="fas fa-pen-alt"></i> يقبل حركة</span>
                                            @endif
                                        </td>
                                    @endif

                                    <td class='p-2'>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('accounts.edit', ['account' => $account->id, 'acc' => $accType]) }}"
                                                class="btn btn-sm btn-success" title="تعديل">
                                                <i class="fas fa-edit "></i>
                                            </a>
                                            @if (!$account->is_basic)
                                                <form action="{{ route('accounts.delete') }}" method="GET"
                                                    class="d-inline"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا الحساب؟');">
                                                    <input type="hidden" name="id" value="{{ $account->id }}">
                                                    <input type="hidden" name="acc" value="{{ $accType }}">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class='p-2' colspan="{{ $accType ? 7 : 6 }}" class="text-center py-5">
                                        <div class="text-muted text-center">
                                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                                            <p>لا توجد بيانات متاحة لهذا القسم</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if (!$accType)
    </div>
    </div>
    @endif
    </div>

    @if (!$accType)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toggler = document.getElementsByClassName("caret");
                for (var i = 0; i < toggler.length; i++) {
                    toggler[i].addEventListener("click", function() {
                        this.parentElement.querySelector(".nested").classList.toggle("active-node");
                        this.classList.toggle("caret-down");
                    });
                }
            });
        </script>
    @endif
@endsection
