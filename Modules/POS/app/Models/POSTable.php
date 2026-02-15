<?php

namespace Modules\POS\Models;

use Illuminate\Database\Eloquent\Model;

class POSTable extends Model
{
    protected $table = 'tables';
    protected $fillable = ['tname', 'table_case', 'branch', 'tenant'];
    public $timestamps = false;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('isdeleted', 0);
    }

    public function scopeAvailable($query)
    {
        return $query->where('table_case', 0)->where('isdeleted', 0);
    }

    public function getStatusLabel()
    {
        return match($this->table_case) {
            0 => 'متاحة',
            1 => 'محجوزة',
            2 => 'صيانة',
            default => 'غير معروف'
        };
    }
}
