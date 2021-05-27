<?php declare(strict_types=1);

namespace App\Http\Repositories\Reservations;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Reservations;
use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class ReservationsRepository extends BaseRepository
{

    /**
     * UserRepository constructor.
     *
     * @param Restaurants $model
     */
    public function __construct(Reservations $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */

    public function fetchTakenTimesTimes(string $date, int $tableId): Collection
    {
        return $this->BaseQuery()
            ->selectRaw(
                'HOUR(start_at) as start, HOUR(end_at) as end'
            )
            ->where([
                ['table_id', $tableId]
            ])
            ->whereDate('start_at', $date)
            ->get();
    }

    public function fetchReservationsByRestaurant(int $restaurantId): Collection
    {
        return $this->BaseQuery()
            ->with([
                'contacts' => function (HasMany $hasMany) {
                    $hasMany->select([
                        'id',
                        'reservation_id',
                        'Name',
                        'Surname',
                        'phone',
                        'email'
                    ]);
                }
            ])
            ->join('tables', function(JoinClause $joinClause) {
                $joinClause->on('tables.id', '=', 'reservations.table_id');
            })
            ->join('restaurants', function (JoinClause  $joinClause) {
                $joinClause->on('restaurants.id', '=', 'tables.restaurant_id');
            })
            ->where([
                ['restaurants.admin_id', Auth::id()],
                ['tables.restaurant_id', $restaurantId]
            ])
            ->select([
                'reservations.id',
                'reservations.client_name',
                'reservations.table_id',
                'reservations.start_at',
                'reservations.end_at'
            ])->get();
    }
}
