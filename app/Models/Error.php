<?php


namespace App\Models;

/**
 *  @OA\Schema(
 *   schema="Error",
 *   type="object"
 * )
 */

class Error
{
    /**
     * @OA\Property(type="string")
     */
    public $message;
}
