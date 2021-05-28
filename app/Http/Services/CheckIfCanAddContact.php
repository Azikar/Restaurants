<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\Tables\TablesRepository;

class CheckIfCanAddContact
{
    private CheckRestaurantLimit $checkRestaurantLimit;
    private TablesRepository $tablesRepository;
    private FormatDate $formatDate;

    public function __construct(
        CheckRestaurantLimit $checkRestaurantLimit,
        TablesRepository $tablesRepository,
        FormatDate $formatDate
    )
    {
        $this->checkRestaurantLimit = $checkRestaurantLimit;
        $this->tablesRepository = $tablesRepository;
        $this->formatDate = $formatDate;
    }

    public function execute(array $attributes): bool
    {
        $table = $this->tablesRepository->getTableByIdAndRestaurantId($attributes['table'], $attributes['restaurant']);
        $start = $this->formatDate->formatDateTime((int)$attributes['date'], $attributes['start']);
        $end = $this->formatDate->formatDateTime((int)$attributes['date'], $attributes['end']);

        return !$this->checkRestaurantLimit->contactsExceedsCurrentRestaurantCap($attributes['contactsCount'], $table->capacity, $attributes['restaurant'], $start, $end);
    }
}
