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
    protected $table = 'nfe_successes';

    protected $fillable = [
        'access_key',
        'amount',
        'xml',
    ];

    /**
     * @OA\Property(type="integer")
     */
    public $id;

    /**
     * @OA\Property(type="string")
     */
    public $access_key;

    /**
     * @OA\Property(type="number")
     */
    public $amount;

    /**
     * @OA\Property(type="string")
     */
    public $xml;

    public function scopeByAccessKey(Builder $builder, string $accessKey): Builder
    {
        return $builder->where('access_key', $accessKey);
    }

}
