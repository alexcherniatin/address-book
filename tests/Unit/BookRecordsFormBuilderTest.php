<?php

declare(strict_types=1);

use AddressBook\Builders\BookRecordsFormBuilder;
use AddressBook\Dto\BookRecord;
use PHPUnit\Framework\TestCase;

final class BookRecordsFormBuilderTest extends TestCase
{
    public function testAddRecordFormCanBeRendered(): void
    {
        $this->assertStringContainsString(
            'Dodaj',
            (new BookRecordsFormBuilder())->form('', null)
        );
    }

    public function testEditRecordFormCanBeRendered(): void
    {
        $fakeData = [
            'id' => 1,
            'first_name' => 'Tester',
            'last_name' => 'Doe',
            'phone' => '704-232-443',
            'email' => 'tester@test.com',
            'address' => 'Unnamed street 21',
            'created_at' => '1676750400',
            'updated_at' => null
        ];

        $this->assertStringContainsString(
            'Zapisz zmiany',
            (new BookRecordsFormBuilder())->form(
                '',
                BookRecord::fromArray($fakeData)
            )
        );
    }
}
