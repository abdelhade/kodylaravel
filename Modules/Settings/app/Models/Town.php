<?php

namespace Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Town extends Model
{
    use HasFactory;

    protected $table = 'towns';
    
    protected $fillable = ['name'];
    
    public $timestamps = false; // Assuming native tables might not have timestamps unless verified
}
