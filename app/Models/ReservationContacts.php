<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationContacts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reservation_id',
        'Name',
        'Surname',
        'phone',
        'email',
    ];
}
