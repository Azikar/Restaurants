<?php declare(strict_types=1);

namespace App\Http\Repositories\Tables;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Restaurants;
use App\Models\Tables;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class TablesRepository extends BaseRepository
{

    /**
     * UserRepository constructor.
     *
     * @param Restaurants $model
     */
    public function __construct(Tables $model)
    {
        parent::__construct($model);
    }

    public function getTablesByRestaurant(int $restaurantId): Collection
    {
        return $this->BaseQuery()
            ->select([
                'tables.id',
                'tables.restaurant_id',
                'tables.table_size'
            ])
            ->join('restaurants', function (JoinClause $joinClause){
                $joinClause->on('tables.restaurant_id', '=', 'restaurants.id');
            })
            ->where([
                ['restaurant_id', $restaurantId],
                ['restaurants.admin_id', Auth::id()]
            ])->get();
    }
}
