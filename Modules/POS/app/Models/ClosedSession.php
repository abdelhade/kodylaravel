<?php

namespace Modules\POS\Models;

use Illuminate\Database\Eloquent\Model;

class ClosedSession extends Model
{
    protected $table = 'closed_orders';
    protected $fillable = [
        'shift', 'user', 'date', 'strttime', 'endtime',
        'total_sales', 'delevery', 'tables', 'takeaway',
        'expenses', 'fund_before', 'fund_after', 'exp_notes',
        'cash', 'info', 'info2', 'tenant', 'branch'
    ];
    public $timestamps = false;

    protected $casts = [
        'date' => 'date',
        'strttime' => 'datetime',
        'total_sales' => 'float',
        'expenses' => 'float',
        'cash' => 'float',
        'fund_before' => 'float',
        'fund_after' => 'float',
    ];
}
