<?php

namespace AddressBook\Core;

use DateTime;

class Utils
{
    /**
     * Create string date from timestamp
     *
     * @param string $timestamp
     * @param string $dateFormat
     *
     * @return string 
     */
    public static function dateFromTimestamp(string $timestamp, string $dateFormat = 'm-d-Y H:i:s'): string
    {
        return (new DateTime())->setTimestamp($timestamp)->format($dateFormat);
    }
}
