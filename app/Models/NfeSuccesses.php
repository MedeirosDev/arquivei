<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 *  @OA\Schema(
 *   schema="NFe",
 *   type="object"
 * )
 */


class NfeSuccesses extends Model
{

    /**
     * @OA\Property(property="id", type="integer")
     * @OA\Property(property="access_key", type="string")
     * @OA\Property(property="amount", type="number", description="NF amount")
     * @OA\Property(property="xml", type="string", description="Url for download xml of NF")
     * @OA\Property(property="created_at", type="string")
     * @OA\Property(property="updated_at", type="string")
     */

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
