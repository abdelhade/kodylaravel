@extends('dashboard.layout')

@section('content')
<div class="container-fluid p-2">
    <h4 class="font-thin text-md text-white text-center"
        style="font-size:2em;padding:15px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius: 10px 10px 0 0;margin:0;">
        محلل العمل اليومي - {{ $report_name }}
    </h4>

    <div class="card" style="border-radius: 0 0 10px 10px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-body p-4">
            <form action="" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>من</label>
                        <input class="form-control" type="date" value="{{ $strtdate }}" name="strtdate">
                    </div>
                    <div class="col-md-4">
                        <label>إلى</label>
                        <input class="form-control" type="date" value="{{ $enddate }}" name="enddate">
                    </div>
                    <div class="col-md-4">
                        <label style="visibility: hidden;">بحث</label>
                        <button class="btn btn-primary btn-block" type="submit">
                            <i class="fa fa-search"></i> بحث
                        </button>
                    </div>
                </div>
            </form>

            <!-- Charts Section -->
            <div class="row mb-4">
                <div class="col-md-6 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> توزيع العمليات حسب النوع</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="operationsTypeChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-success text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-bar"></i> المقارنة المالية</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="financialComparisonChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards with Animation -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="alert alert-info text-center shadow-sm" style="border-left: 5px solid #17a2b8;">
                        <h5><i class="fas fa-calculator"></i> إجمالي</h5>
                        <h2 id="total" class="counter" style="font-size: 2.5em; font-weight: bold;">0.00</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-success text-center shadow-sm" style="border-left: 5px solid #28a745;">
                        <h5><i class="fas fa-money-bill"></i> صافي</h5>
                        <h2 id="fatnet" class="counter" style="font-size: 2.5em; font-weight: bold;">0.00</h2>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-warning text-center shadow-sm" style="border-left: 5px solid #ffc107;">
                        <h5><i class="fas fa-chart-line"></i> أرباح</h5>
                        <h2 id="profit" class="counter" style="font-size: 2.5em; font-weight: bold;">0.00</h2>
                    </div>
                </div>
            </div>

            <!-- Line Chart for Trend -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-info text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-line"></i> اتجاه العمليات خلال الفترة</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="operationsTrendChart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm table-striped" id="operationsTable" data-page-length="10">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>الوقت و التاريخ</th>
                                    <th>اسم العملية</th>
                                    <th>قيمة العملية</th>
                                    <th>صافي العملية</th>
                                    <th>الحساب</th>
                                    <th>الحساب المقابل</th>
                                    <th>المخزن</th>
                                    <th>الموظف</th>
                                    <th>الربح</th>
                                    <th>المستخدم</th>
                                    <th>معرف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $x = 0; @endphp
                                @foreach($operations as $rowop)
                                    @php 
                                        $x++;
                                        $proid = $rowop->id;
                                        $tybe = $rowop->pro_tybe;
                                        $proTypeName = $proTypes[$tybe] ?? '';
                                        $acc1Name = $accounts[$rowop->acc1] ?? '';
                                        $acc2Name = $accounts[$rowop->acc2] ?? '';
                                        $storeName = ($rowop->store_id > 0 && isset($accounts[$rowop->store_id])) ? $accounts[$rowop->store_id] : '';
                                        $empName = ($rowop->emp_id > 0 && isset($accounts[$rowop->emp_id])) ? $accounts[$rowop->emp_id] : '';
                                        $userName = $users[$rowop->user] ?? '';
                                    @endphp
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td>{{ $rowop->crtime }}</td>
                                        <td>
                                            <a class="btn btn-block btn-light border" 
                                               href="{{ asset('native/print/' . (($tybe == 4 || $tybe == 3) ? 'print_sales' : 'receipt') . '.php?id=' . $proid) }}" 
                                               target="_blank">
                                                {{ $proTypeName }}
                                            </a>
                                        </td>
                                        <td class="value">{{ number_format($rowop->pro_value ?? 0, 2) }}</td>
                                        <td class="fatnet {{ $rowop->pro_value != $rowop->fat_net ? 'bg-yellow-300' : '' }}">{{ number_format($rowop->fat_net ?? 0, 2) }}</td>
                                        <td>{{ $acc1Name }}</td>
                                        <td>{{ $acc2Name }}</td>
                                        <td>{{ $storeName }}</td>
                                        <td>{{ $empName }}</td>
                                        <td class="prft">{{ number_format(($rowop->fat_net ?? 0) - ($rowop->fat_cost ?? 0), 2) }}</td>
                                        <td>{{ $userName }}</td>
                                        <td>
                                            {{ $rowop->id }}
                                            
                                            @if(in_array($tybe, [3, 4, 9]))
                                            <a href="{{ route('sales.index', ['edit_id' => $rowop->id]) }}" class="btn btn-sm btn-warning" title="تعديل">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endif

                                            <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $rowop->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <form action="{{ asset('native/do/dodel_invoice.php?id=' . $rowop->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="q" value="{{ $q }}">
                                            
                                                <div class="modal fade" id="deleteModal{{ $rowop->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف {{ $rowop->id }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>هل أنت متأكد من أنك تريد حذف هذه الفاتورة؟</p>
                                                                <p><strong>رقم الفاتورة:</strong> {{ $rowop->id }}</p>
                                                                <p><strong>نوع العملية:</strong> {{ $proTypeName }}</p>
                                                                <label for="pass">كلمة المرور:</label>
                                                                <input type="password" name="pass" class="form-control hover:bg-orange-300" placeholder="أدخل كلمة مرور الحذف" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-danger">حذف</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="row mt-3" style="display: none;">
                            <div class="col-md-4">
                                <div class="alert alert-info text-center">
                                    <h5><i class="fas fa-calculator"></i> إجمالي</h5>
                                    <h4 id="total_old">0.00</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-success text-center">
                                    <h5><i class="fas fa-money-bill"></i> صافي</h5>
                                    <h4 id="fatnet_old">0.00</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-warning text-center">
                                    <h5><i class="fas fa-chart-line"></i> أرباح</h5>
                                    <h4 id="profit_old">0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Calculate totals
        const total = Array.from(document.querySelectorAll(".value")).reduce((sum, el) => sum + parseFloat(el.textContent.replace(/,/g, '') || 0), 0);
        const fatnet = Array.from(document.querySelectorAll(".fatnet")).reduce((sum, el) => sum + parseFloat(el.textContent.replace(/,/g, '') || 0), 0);
        const profit = Array.from(document.querySelectorAll(".prft")).reduce((sum, el) => sum + parseFloat(el.textContent.replace(/,/g, '') || 0), 0);
        
        // Animate counters
        animateValue("total", 0, total, 1500);
        animateValue("fatnet", 0, fatnet, 1500);
        animateValue("profit", 0, profit, 1500);

        // Collect data for charts
        const operationsData = {};
        const dateData = {};
        
        document.querySelectorAll("#operationsTable tbody tr").forEach(row => {
            const cells = row.querySelectorAll("td");
            if (cells.length > 2) {
                const type = cells[2].textContent.trim();
                const value = parseFloat(cells[3].textContent.replace(/,/g, '') || 0);
                const date = cells[1].textContent.trim().split(' ')[0]; // Get date only
                
                operationsData[type] = (operationsData[type] || 0) + value;
                dateData[date] = (dateData[date] || 0) + value;
            }
        });

        // Chart 1: Operations Type Pie Chart
        const ctx1 = document.getElementById('operationsTypeChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: Object.keys(operationsData),
                datasets: [{
                    data: Object.values(operationsData),
                    backgroundColor: [
                        '#667eea',
                        '#764ba2',
                        '#f093fb',
                        '#4facfe',
                        '#43e97b',
                        '#fa709a',
                        '#fee140',
                        '#30cfd0'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                family: 'Cairo, sans-serif',
                                size: 12
                            },
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed.toFixed(2);
                            }
                        }
                    }
                }
            }
        });

        // Chart 2: Financial Comparison Bar Chart
        const ctx2 = document.getElementById('financialComparisonChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['الإجمالي', 'الصافي', 'الأرباح'],
                datasets: [{
                    label: 'القيمة',
                    data: [total, fatnet, profit],
                    backgroundColor: [
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderColor: [
                        'rgb(23, 162, 184)',
                        'rgb(40, 167, 69)',
                        'rgb(255, 193, 7)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Cairo, sans-serif'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Cairo, sans-serif',
                                size: 14
                            }
                        }
                    }
                }
            }
        });

        // Chart 3: Operations Trend Line Chart
        const ctx3 = document.getElementById('operationsTrendChart').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: Object.keys(dateData),
                datasets: [{
                    label: 'قيمة العمليات',
                    data: Object.values(dateData),
                    fill: true,
                    backgroundColor: 'rgba(102, 126, 234, 0.2)',
                    borderColor: 'rgb(102, 126, 234)',
                    borderWidth: 3,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: 'rgb(102, 126, 234)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: {
                                family: 'Cairo, sans-serif',
                                size: 14
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Cairo, sans-serif'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Cairo, sans-serif'
                            }
                        }
                    }
                }
            }
        });
    });

    // Counter animation function
    function animateValue(id, start, end, duration) {
        const obj = document.getElementById(id);
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        
        const timer = setInterval(function() {
            current += increment;
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            obj.textContent = current.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }, 16);
    }
</script>

<style>
    .counter {
        transition: all 0.3s ease;
    }
    
    .alert {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .alert:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .card {
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-3px);
    }
</style>
@endsection
