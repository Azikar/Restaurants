<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Enumerators\HoursEnum;
use App\Http\Repositories\Base\BaseRepository;
use App\Http\Repositories\Reservations\ReservationsRepository;
use App\Http\Repositories\Restaurants\RestaurantsRepository;
use App\Http\Repositories\Tables\TablesRepository;
use App\Models\Restaurants;
use App\Models\Tables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


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
        $response = false;
        $hoursToDisable = [];
        $availableHours = HoursEnum::HOURS;
        $newformat = date('Y-m-d',(int) $attributes['date']);
        $takenTimes = $this->reservationsRepository->fetchTakenTimesTimes($newformat, $attributes['table']);
//        dd($takenTimes);
        foreach ($takenTimes as $takenTime)
        {
            $start = $takenTime->start;
//            dd($start, $takenTime->end);
            while ($start < $takenTime->end) {
                $hoursToDisable[] = $start;
                $start ++;
            }

        }

//dd($hoursToDisable, array_diff($availableHours, $hoursToDisable));
        return $hoursToDisable;
    }


}
