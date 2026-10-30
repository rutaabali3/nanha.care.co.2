<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    public static function timeAgo(Carbon $date): string
    {
        return $date->diffForHumans();
    }

    public static function formatPk(Carbon $date): string
    {
        return $date->format('d M Y, h:i A');
    }

    public static function slaDue(Carbon $createdAt, int $hours = 24): array
    {
        $now = Carbon::now();
        $hoursElapsed = (int) $createdAt->diffInHours($now);

        return [
            'overdue' => $hoursElapsed > $hours,
            'hours_elapsed' => $hoursElapsed,
            'label' => $hoursElapsed > $hours
                ? 'Overdue by '.($hoursElapsed - $hours).' hours'
                : ($hours - $hoursElapsed).' hours remaining',
        ];
    }

    public static function ageFromDob(Carbon $dob): string
    {
        $now = Carbon::now();
        $years = (int) $dob->diffInYears($now);
        $months = (int) $dob->copy()->addYears($years)->diffInMonths($now);

        if ($years > 0) {
            return $years.' year'.($years > 1 ? 's' : '');
        }

        return $months.' month'.($months > 1 ? 's' : '');
    }
}
