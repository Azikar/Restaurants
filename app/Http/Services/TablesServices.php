<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\Restaurants\RestaurantsRepository;
use App\Http\Repositories\Tables\TablesRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TablesServices
{

    private TablesRepository $tablesRepository;
    private RestaurantsRepository $restaurantsRepository;

    public function __construct(TablesRepository $tablesRepository, RestaurantsRepository $restaurantsRepository)
    {
        $this->tablesRepository = $tablesRepository;
        $this->restaurantsRepository = $restaurantsRepository;
    }

    /**
     * @return Collection
     */
    public function addNewTable(array $attributes): bool
    {
        $response = false;
        if ($this->restaurantsRepository->restaurantBelongsToUser(Auth::id(), $attributes['restaurant_id'])) {
            $this->tablesRepository->create($attributes);
            $response = true;
        }

        return $response;
    }
}
