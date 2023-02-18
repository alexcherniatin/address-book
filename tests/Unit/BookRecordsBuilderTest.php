<?php

declare(strict_types=1);

use AddressBook\Builders\BookRecordsBuilder;
use AddressBook\Dto\BookRecord;
use PHPUnit\Framework\TestCase;

final class BookRecordsBuilderTest extends TestCase
{
    public function testBuildListReturnsNoContentOnEmptyBookRecords(): void
    {
        $resultHtml = (new BookRecordsBuilder())->buildList([]);

        $this->assertStringContainsString('Brak informacji', $resultHtml);
    }

    public function testBuildListReturnsListOfItemsOnNonEmptyBookRecords(): void
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

        $resultHtml = (new BookRecordsBuilder())->buildList([
            BookRecord::fromArray($fakeData)
        ]);

        $this->assertStringContainsString($fakeData['first_name'], $resultHtml);
    }
}
