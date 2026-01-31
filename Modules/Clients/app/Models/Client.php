<?php

namespace Modules\Clients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Settings\Models\Town;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'city',
        'gender',
        'height',
        'weight',
        'dateofbirth',
        'ref',
        'diseses',
        'info'
    ];

    public $timestamps = false; // Assuming native uses implicit timestamps or none

    public function town()
    {
        return $this->belongsTo(Town::class, 'city');
    }
}
