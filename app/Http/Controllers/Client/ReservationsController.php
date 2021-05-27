<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Reservations\ReservationsRepository;
use App\Http\Repositories\Restaurants\RestaurantsRepository;
use App\Http\Requests\CreateRestaurantRequest;
use App\Http\Services\GetAllowedHours;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\Inertia;

class ReservationsController
{
    public function allowedHours(GetAllowedHours $getAllowedHours, Request $request): JsonResponse
    {
//        dd($request->all());
//        dd($restaurantsRepository->fetchRestaurantsWithTablesForClient()->toArray());
//        return Inertia::render('ReservationForm/ReservationForm')->with(['restaurants'=> $restaurantsRepository->fetchRestaurantsWithTablesForClient()]);
        return response()->json($getAllowedHours->getAllowedHours(
            $request->all()
        ));
    }
}
