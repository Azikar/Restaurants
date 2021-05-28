<?php declare(strict_types=1);

namespace App\Http\Services;

class FormatDate
{
    public function formatDateTime(int $date, int $hour): string
    {
        $newformat = date('Y-m-d',(int) $date);
        $newformat = new \DateTime($newformat);
        $newformat->setTime($hour, 0,0);

        return $newformat->format('Y-m-d H:i:s');
    }
}
