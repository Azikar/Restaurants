<?php declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Enumerators\ErrorsTexts;
use App\Http\Requests\CheckIfCanAddMoreRequest;
use App\Http\Services\CheckIfCanAddContact;
use Illuminate\Http\JsonResponse;

class ReservationContactsController
{
    private CheckIfCanAddContact $checkIfCanAddContact;

    public function __construct(CheckIfCanAddContact $checkIfCanAddContact)
    {
        $this->checkIfCanAddContact = $checkIfCanAddContact;
    }
    public function checkIfCanAddContact(CheckIfCanAddMoreRequest $request): JsonResponse
    {
        $response = $this->checkIfCanAddContact->execute($request->all());

        return response()->json([
            'errors' => !$response ? ['error' => [ErrorsTexts::RESTAURANT_LIMIT]] : [],
        ], !$response ? 400 : 200);
    }
}
