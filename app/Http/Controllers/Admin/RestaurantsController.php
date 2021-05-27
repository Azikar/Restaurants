<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Restaurants\RestaurantsRepository;
use App\Http\Requests\CreateRestaurantRequest;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantsController
{
    public function __construct()
    {

    }

    public function store(CreateRestaurantRequest $request, RestaurantsRepository $restaurantsRepository): JsonResponse
    {
        $restaurantsRepository->create(
        [
            'name' => $request->name,
            'max_people' => $request->max_people,
            'tables_count' => $request->tables_count,
            'admin_id'=> Auth::id()
        ]);

        return response()->json(['status' => 'success'], 201);
    }

    public function index(RestaurantsRepository $restaurantsRepository): JsonResponse
    {
        return response()->json([
            'data' => $restaurantsRepository->fetchRestaurantsWithTables(),
        ],200);
    }
}
