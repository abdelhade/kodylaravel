<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'acc_head';

    protected $fillable = [
        'code',
        'aname',
        'is_basic',
        'parent_id',
        'kind',
        'phone',
        'address',
        'isdeleted',
        'is_fund',
        'rentable',
        'is_stock',
        'secret',
    ];

    public $timestamps = true;

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::addGlobalScope('supplier', function (Builder $builder) {
            $builder->where('code', 'like', '211%')
                    ->where('is_basic', 0)
                    ->where('isdeleted', '<', 1);
        });
    }

    /**
     * Get the parent account.
     */
    public function parent()
    {
        return $this->belongsTo(Supplier::class, 'parent_id')->withoutGlobalScope('supplier');
    }
}
