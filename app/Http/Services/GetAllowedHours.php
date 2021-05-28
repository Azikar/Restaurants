<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\Reservations\ReservationsRepository;
use Illuminate\Support\Collection;

class GetAllowedHours
{

    private ReservationsRepository $reservationsRepository;

    public function __construct(ReservationsRepository $reservationsRepository)
    {
        $this->reservationsRepository = $reservationsRepository;
    }

    /**
     * @return Collection
     */
    public function getAllowedHours(array $attributes): array
    {
        $hoursToDisable = [];
        $newformat = date('Y-m-d',(int) $attributes['date']);
        $takenTimes = $this->reservationsRepository->fetchTakenTimesTimes($newformat, $attributes['table']);
        foreach ($takenTimes as $takenTime)
        {
            $start = $takenTime->start;
            while ($start < $takenTime->end) {
                $hoursToDisable[] = $start;
                $start ++;
            }
        }

        return $hoursToDisable;
    }


}
