<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nfe extends Model
{

    protected $table = 'nfes';

    protected $fillable = [
        'access_key',
        'amount',
        'xml',
    ];

}
