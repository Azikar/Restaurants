<?php declare(strict_types=1);


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Restaurants\RestaurantsRepository;
use App\Http\Repositories\Tables\TablesRepository;
use App\Http\Requests\CreateRestaurantRequest;


use App\Http\Requests\CreateTablesRequest;
use App\Http\Services\TablesServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TablesController
{
    private TablesServices $tablesServices;
    private TablesRepository $tablesRepository;

    public function __construct(TablesServices $tablesServices, TablesRepository $tablesRepository)
    {
        $this->tablesServices = $tablesServices;
        $this->tablesRepository = $tablesRepository;
    }

    public function index(int $restautantId)
    {
        $data = $this->tablesRepository->getTablesByRestaurant($restautantId);

        return Inertia::render('Tables/TablesIndex')->with(['tables'=> $data, 'restaurantId' => $restautantId]);
    }

    public function store(CreateTablesRequest $request)
    {
        $response = response()->json(['status' => 'fail'], 400);
        if ($this->tablesServices->addNewTable([
            'table_size' => $request->table_size,
            'restaurant_id' => $request->restaurant_id
        ]))
        {
            $response = response()->json(['status' => 'success'], 201);
        }

        return $response;
    }
}
