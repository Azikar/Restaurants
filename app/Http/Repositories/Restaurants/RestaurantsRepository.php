<?php declare(strict_types=1);

namespace App\Http\Repositories\Restaurants;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Restaurants;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RestaurantsRepository extends BaseRepository
{

    /**
     * UserRepository constructor.
     *
     * @param Restaurants $model
     */
    public function __construct(Restaurants $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function restaurantBelongsToUser(int $userId, int $restaurantId): bool
    {
        return $this->baseQuery()->where([
            ['admin_id', $userId],
            ['id', $restaurantId]
        ])->exists();
    }

    public function fetchRestaurantsWithTables(): Collection
    {
        return $this->baseQuery()
            ->select([
                'id',
                'admin_id',
                'name',
            ])
            ->addSelect(DB::raw('(select COUNT(id) from `tables` where `tables`.`restaurant_id` = `restaurants`.`id`) as tables_count'))
            ->with([
                'tables' => function (HasMany $hasMany) {
                    return $hasMany->select([
                        'id',
                        'restaurant_id',
                        'table_size'
                    ]);
                }
            ])
            ->where([
                ['admin_id', Auth::id()]
            ])->get();
    }
    public function fetchRestaurantsWithTablesForClient(): Collection
    {
        return $this->baseQuery()
            ->select([
                'id',
                'admin_id',
                'name',
                'max_people'
            ])
            ->with([
                'tables' => function (HasMany $hasMany) {
                    $hasMany->select([
                        'id',
                        'restaurant_id',
                        'table_size',
                    ]);
                }
            ])->get();
    }
}
