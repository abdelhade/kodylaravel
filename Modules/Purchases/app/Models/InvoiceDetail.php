<?php

namespace Modules\Purchases\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'fat_details';
    
    // تعطيل timestamps الافتراضية
    public $timestamps = false;
    
    protected $fillable = [
        'fat_id',
        'item_id',
        'quantity',
        'price',
        'total',
        'crtime'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->crtime = now();
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'fat_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
