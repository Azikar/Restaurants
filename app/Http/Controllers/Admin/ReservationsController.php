<?php declare(strict_types=1);


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Reservations\ReservationsRepository;
use App\Http\Repositories\Restaurants\RestaurantsRepository;
use App\Http\Repositories\Tables\TablesRepository;
use App\Http\Requests\CreateRestaurantRequest;


use App\Http\Requests\CreateTablesRequest;
use App\Http\Services\TablesServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationsController
{

    private RestaurantsRepository $restaurantsRepository;
    private ReservationsRepository $reservationsRepository;

    public function __construct(RestaurantsRepository $restaurantsRepository, ReservationsRepository $reservationsRepository)
    {
        $this->restaurantsRepository = $restaurantsRepository;
        $this->reservationsRepository = $reservationsRepository;
    }

    public function index(int $restaurantId)
    {
        if ($this->restaurantsRepository->restaurantBelongsToUser(Auth::id(), $restaurantId)) {
            $data = $this->reservationsRepository->fetchReservationsByRestaurant($restaurantId);
        }

        return Inertia::render('Reservations/ReservationsIndex')->with(['reservations'=> $data, 'restaurantId' => $restaurantId]);
    }
}
