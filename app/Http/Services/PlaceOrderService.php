<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Enumerators\ErrorsTexts;
use App\Http\Repositories\Contacts\ContactsRepository;
use App\Http\Repositories\Reservations\ReservationsRepository;
use App\Http\Repositories\Tables\TablesRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlaceOrderService
{

    private ReservationsRepository $reservationsRepository;
    private TablesRepository $tablesRepository;
    private ContactsRepository $contactsRepository;
    private FormatDate $formatDate;
    private CheckRestaurantLimit $checkRestaurantLimit;
    private CheckTableLimit $checkTableLimit;
    private CheckIfTimeIsTaken $checkIfTimeIsTaken;

    public function __construct(ReservationsRepository $reservationsRepository,
                                TablesRepository $tablesRepository,
                                ContactsRepository $contactsRepository,
                                FormatDate $formatDate,
                                CheckRestaurantLimit $checkRestaurantLimit,
                                CheckTableLimit $checkTableLimit,
                                CheckIfTimeIsTaken $checkIfTimeIsTaken
    ) {
        $this->reservationsRepository = $reservationsRepository;
        $this->tablesRepository = $tablesRepository;
        $this->contactsRepository = $contactsRepository;
        $this->formatDate = $formatDate;
        $this->checkRestaurantLimit = $checkRestaurantLimit;
        $this->checkTableLimit = $checkTableLimit;
        $this->checkIfTimeIsTaken = $checkIfTimeIsTaken;
    }

    /**
     * @return Collection
     */
    public function placeOrder(array $attributes): array
    {
        try {
            DB::beginTransaction();
            $table = $this->tablesRepository->getTableByIdAndRestaurantId($attributes['table'], $attributes['restaurant']);
            $start = $this->formatDate->formatDateTime((int)$attributes['date'], $attributes['start']);
            $end = $this->formatDate->formatDateTime((int)$attributes['date'], $attributes['end']);
            $intercepts = $this->checkIfTimeIsTaken->intercepts($table->id, $start, $end);
            $exceedTable = $this->checkTableLimit->contactsExceedsTableSize(count($attributes['contacts']), $table->table_size);
            $exceedRestaurant = $this->checkRestaurantLimit->contactsExceedsCurrentRestaurantCap(count($attributes['contacts']), $table->capacity, $attributes['restaurant'], $start, $end);
            $errors = $this->collectErrors($intercepts, $exceedTable, $exceedRestaurant);
            if (
                $table
                && !$intercepts
                && !$exceedTable
                && !$exceedRestaurant
            ) {
                $this->createReservation($attributes, $start, $end);
            }
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            $errors['server'] = [ErrorsTexts::SERVER];
        }

        return $errors;
    }

    private function createReservation(array $data, string $start, string $end): void
    {
        $reservation = $this->reservationsRepository->create(
            [
                'client_name' => $data['name'],
                'table_id' => $data['table'],
                'start_at' => $start,
                'end_at' => $end,
            ]);
        $contactsData = [];
        foreach ($data['contacts'] as $contact) {
            $contactsData[] = [
                'reservation_id' => $reservation->id,
                'Name' => $contact['name'],
                'Surname' => $contact['surname'],
                'phone' => $contact['phone'],
                'email' => $contact['email']
            ];
        }

        $this->contactsRepository->insert($contactsData);
    }

    private function collectErrors(bool $intercepts, bool $exceedTable, bool $exceedRestaurant): array
    {
        $errors = [];
        if ($intercepts) {
            $errors['intercepts'] = [ErrorsTexts::INTERCEPTS];
        }
        if ($exceedTable) {
            $errors['table'] = [ErrorsTexts::GUESTS_EXCEEDS_TABLE];
        }
        if ($exceedRestaurant) {
            $errors['restaurant'] = [ErrorsTexts::RESTAURANT_LIMIT];
        }

        return $errors;
    }
}
