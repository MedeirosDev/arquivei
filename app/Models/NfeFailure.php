<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NfeFailure extends Model
{
    protected $table = 'nfes_failure';

    protected $fillable = [
        'access_key',
        'message',
        'xml',
    ];
}
