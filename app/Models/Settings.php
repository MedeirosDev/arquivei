<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
    use SoftDeletes;

    protected $table = 'settings';

    protected $fillable = [
        'path_successes',
        'path_failures',
        'last_cursor',
    ];
}
