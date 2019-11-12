<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NfeFailures extends Model
{
    protected $table = 'nfe_failures';

    protected $fillable = [
        'access_key',
        'message',
        'amount',
        'xml',
    ];
}
