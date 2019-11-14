<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NfeFailures extends Model
{

    /**
     * *OA\Property(property="id", type="integer")
     * *OA\Property(property="access_key", type="string")
     * *OA\Property(property="message", type="string", description="Failure reason description")
     * *OA\Property(property="amount", type="number", description="NF amount")
     * *OA\Property(property="xml", type="string", description="Url for download xml of NF")
     * *OA\Property(property="created_at", type="string")
     * *OA\Property(property="updated_at", type="string")
     */

    protected $table = 'nfe_failures';

    protected $fillable = [
        'access_key',
        'message',
        'amount',
        'xml',
    ];

}
