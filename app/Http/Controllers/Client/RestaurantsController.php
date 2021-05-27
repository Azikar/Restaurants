<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Restaurants\RestaurantsRepository;
use App\Http\Requests\CreateRestaurantRequest;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\Inertia;

class RestaurantsController
{
    public function __construct()
    {

    }

    public function index(RestaurantsRepository $restaurantsRepository): Response
    {
//        dd($restaurantsRepository->fetchRestaurantsWithTablesForClient()->toArray());
        return Inertia::render('ReservationForm/ReservationForm')->with(['restaurants'=> $restaurantsRepository->fetchRestaurantsWithTablesForClient()]);
    }
}
