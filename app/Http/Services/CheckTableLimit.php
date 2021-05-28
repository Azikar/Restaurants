<?php declare(strict_types=1);

namespace App\Http\Services;

class CheckTableLimit
{
    public function contactsExceedsTableSize(int $contactsCount, int $tableSize): bool
    {
        return $contactsCount > $tableSize;
    }
}
