<?php

declare(strict_types=1);

namespace App\Command;

use DateInterval;
use DateTime;

trait NotifySubscribersTrait
{
    public const URL_BIN_GUIDE              = "https://your.regional.council.org.au/bin-guide.pdf";
    public const DATE_FORMAT_HUMAN_READABLE = 'l, F jS, o';
    public const DATE_INTERVAL_ONE_MONTH    = 'P1M';

    private function getNextBinCollectionDay(string $binCollectionDay): string
    {
        $today             = new DateTime();
        $nextCollectionDay = new DateTime($binCollectionDay);

        if ($nextCollectionDay < $today) {
            $nextCollectionDay->add(new DateInterval(self::DATE_INTERVAL_ONE_MONTH));
        }

        // Returns the date in a human-readable format, such as "Tuesday, April 18th, 2023".
        return $nextCollectionDay->format(self::DATE_FORMAT_HUMAN_READABLE);
    }
}
