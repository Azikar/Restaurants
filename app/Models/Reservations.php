<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservations extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_name',
        'table_id',
        'start_at',
        'end_at',
        'table_id',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(ReservationContacts::class, 'reservation_id', 'id');
    }
}
