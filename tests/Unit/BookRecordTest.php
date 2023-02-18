<?php

declare(strict_types=1);

use AddressBook\Dto\BookRecord;
use PHPUnit\Framework\TestCase;

final class BookRecordTest extends TestCase
{
    public function testBookRecordCanBeCreatedFromArray()
    {
        $createdFromArray = BookRecord::fromArray([
            'id' => 1,
            'first_name' => 'Tester',
            'last_name' => 'Doe',
            'phone' => '704-232-443',
            'email' => 'tester@test.com',
            'address' => 'Unnamed street 21',
            'created_at' => '1676750400',
            'updated_at' => null
        ]);

        $createdWithConstructor = new BookRecord(
            1,
            'Tester',
            'Doe',
            '704-232-443',
            'tester@test.com',
            'Unnamed street 21',
            '1676750400',
            null
        );

        $this->assertInstanceOf(BookRecord::class, $createdFromArray);

        $this->assertTrue($createdWithConstructor == $createdFromArray);
    }
}
