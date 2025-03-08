<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailSubscriber extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'email',
        'location',
        'is_notified'
    ];
}
