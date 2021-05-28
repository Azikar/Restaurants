<?php declare(strict_types=1);

namespace App\Http\Repositories\Contacts;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\ReservationContacts;
use App\Models\Reservations;
use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ContactsRepository extends BaseRepository
{

    /**
     * UserRepository constructor.
     *
     * @param Restaurants $model
     */
    public function __construct(ReservationContacts $model)
    {
        parent::__construct($model);
    }

    public function insert(array $attributes): void
    {
        DB::table('reservation_contacts')->insert($attributes);
    }
}
