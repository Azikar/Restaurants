<?php
namespace App\Http\Controllers\Client;

use App\Http\Requests\AllowedHoursRequest;
use App\Http\Requests\PlaceReservationRequest;
use App\Http\Services\GetAllowedHours;
use App\Http\Services\PlaceOrderService;
use Illuminate\Http\JsonResponse;

class ReservationsController
{
    public function allowedHours(GetAllowedHours $getAllowedHours, AllowedHoursRequest $request): JsonResponse
    {
        return response()->json($getAllowedHours->getAllowedHours(
            $request->all()
        ));
    }

    public function placeReservation(PlaceReservationRequest $request,PlaceOrderService $placeOrderService): JsonResponse
    {
        $errors = $placeOrderService->placeOrder($request->all());

        return response()->json([
            'errors' => $errors,
        ], empty($errors) ? 200 : 400);
    }
}
