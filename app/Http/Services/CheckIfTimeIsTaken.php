<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\Reservations\ReservationsRepository;

class CheckIfTimeIsTaken
{
    private ReservationsRepository $reservationsRepository;

    public function __construct(ReservationsRepository $reservationsRepository)
    {
        $this->reservationsRepository = $reservationsRepository;
    }

    public function intercepts(int $tableId, string $start, string $end): bool
    {
        return $this->reservationsRepository->existsInTimeSpan($tableId, $start, $end);
    }
}
