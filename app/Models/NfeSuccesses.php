<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NfeSuccesses extends Model
{
    protected $table = 'nfe_successes';

    protected $fillable = [
        'access_key',
        'amount',
        'xml',
    ];

    public function scopeByAccessKey(Builder $builder, string $accessKey): Builder
    {
        return $builder->where('access_key', $accessKey);
    }

}
