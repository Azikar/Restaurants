<?php declare(strict_types=1);

namespace App\Enumerators;

class ErrorsTexts
{
    public const INTERCEPTS = 'Selected time is already taken';
    public const GUESTS_EXCEEDS_TABLE = 'Selected time is already filled';
    public const RESTAURANT_LIMIT = 'Restaurant maximum visitors limit has been reached';
    public const SERVER = 'Something went wrong';
}
