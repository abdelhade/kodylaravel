<?php

namespace Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'ot_head';
    
    // تعطيل timestamps الافتراضية لأن الجدول يستخدم crtime و mdtime
    public $timestamps = false;
    
    protected $fillable = [
        'pro_date',
        'pro_tybe',
        'user',
        'fat_total',
        'fat_disc',
        'fat_net',
        'info',
        'isdeleted',
        'crtime',
        'mdtime'
    ];

    protected $casts = [
        'pro_date' => 'date',
        'fat_total' => 'decimal:2',
        'fat_disc' => 'decimal:2',
        'fat_net' => 'decimal:2',
        'isdeleted' => 'boolean',
    ];

    // تعيين القيم التلقائية عند الإنشاء
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->crtime = now();
            $model->mdtime = now();
            if (!isset($model->isdeleted)) {
                $model->isdeleted = 0;
            }
        });
        
        static::updating(function ($model) {
            $model->mdtime = now();
        });
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'fat_id', 'id');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('isdeleted', 0);
    }

    public function scopeSales($query)
    {
        return $query->where('pro_tybe', 1);
    }

    public function scopeSaleReturns($query)
    {
        return $query->where('pro_tybe', 7);
    }
}
