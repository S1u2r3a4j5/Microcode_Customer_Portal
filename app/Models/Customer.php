<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     required={"first_name", "last_name", "age", "dob", "email"},
 *     @OA\Property(property="id", type="integer", description="Customer ID"),
 *     @OA\Property(property="first_name", type="string", description="First Name"),
 *     @OA\Property(property="last_name", type="string", description="Last Name"),
 *     @OA\Property(property="age", type="integer", description="Age"),
 *     @OA\Property(property="dob", type="string", format="date", description="Date of Birth"),
 *     @OA\Property(property="email", type="string", format="email", description="Email address"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation Timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update Timestamp")
 * )
 */

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'dob',
        'email',
        'creation_date',
    ];
}
