<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\Reservations\ReservationsRepository;

class CheckRestaurantLimit
{

    private ReservationsRepository $reservationsRepository;

    public function __construct(ReservationsRepository $reservationsRepository)
    {
        $this->reservationsRepository = $reservationsRepository;
    }

    public function contactsExceedsCurrentRestaurantCap(int $contactsCount, int $capacity, int $restaurantId, string $start, string $end): bool
    {
        return ($contactsCount + array_sum($this->reservationsRepository->getAmountOfPeopleInTimeSpan($restaurantId, $start, $end)) > $capacity);
    }
}
