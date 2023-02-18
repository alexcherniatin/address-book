<?php

declare(strict_types=1);

use AddressBook\Core\Utils;
use AddressBook\Exceptions\AddressBookException;
use PHPUnit\Framework\TestCase;

final class UtilsTest extends TestCase
{
    public function testStringDateCanBeGeneratedFromTimestamp(): void
    {
        $this->assertSame(
            '18-02-2023 20:00:00',
            Utils::dateFromTimestamp('1676750400')
        );
    }

    public function testExceptionThrownOnInvalidTimestamp(): void
    {
        $this->expectException(AddressBookException::class);

        Utils::dateFromTimestamp('qweqweqwe');
    }

    public function testTimestampValidationTrueOnValidTimestamp(): void
    {
        $this->assertTrue(Utils::isValidTimeStamp('1676750400'));
    }

    public function testTimestampValidationFalseOnInvalidTimestamp(): void
    {
        $this->assertFalse(Utils::isValidTimeStamp('jasdjq'));
    }
}
