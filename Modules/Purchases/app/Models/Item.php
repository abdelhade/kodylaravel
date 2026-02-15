<?php

namespace Modules\Purchases\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'myitems';
    
    protected $fillable = [
        'itmname',
        'itmqty',
        'cost_price',
        'last_price',
        'sale_price',
        'barcode',
        'store_id',
        'category_id',
        'unit_id',
        'isdeleted'
    ];

    protected $casts = [
        'itmqty' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'last_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'isdeleted' => 'boolean',
    ];

    public function scopeNotDeleted($query)
    {
        return $query->where('isdeleted', 0);
    }
}
