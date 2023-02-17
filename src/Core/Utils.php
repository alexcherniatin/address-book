<?php

namespace AddressBook\Core;

use DateTime;

class Utils
{
    public static function dateFromTimestamp(string $timestamp, string $dateFormat = 'm-d-Y H:i:s'): string
    {
        return (new DateTime())->setTimestamp($timestamp)->format($dateFormat);
    }
}
