<?php

namespace AddressBook\Core;

use AddressBook\Exceptions\AddressBookException;
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
    public static function dateFromTimestamp(string $timestamp, string $dateFormat = 'd-m-Y H:i:s'): string
    {
        if (!self::isValidTimeStamp($timestamp)) {
            throw new AddressBookException("Given string is not a valid timestamp");
        }

        return (new DateTime())->setTimestamp($timestamp)->format($dateFormat);
    }

    /**
     * Check is string timestamp
     *
     * @param string $timestamp Timestamp
     *
     * @return bool 
     */
    public static function isValidTimeStamp(string $timestamp): bool
    {
        return ((string) (int) $timestamp === $timestamp)
            && ($timestamp <= PHP_INT_MAX)
            && ($timestamp >= ~PHP_INT_MAX);
    }

    /**
     * Get now timestamp
     * 
     * @return string 
     */
    public static function nowTimestamp(): string
    {
        return (new DateTime())->getTimestamp();
    }
}
