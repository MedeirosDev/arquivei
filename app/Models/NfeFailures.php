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

    public $id;
    public $access_key;
    public $message;
    public $amount;
    public $xml;
    public $created_at;
    public $updated_at;
}
