<?php

declare(strict_types=1);

use AddressBook\Core\Utils;
use AddressBook\Dto\BookRecord;
use AddressBook\Models\BookRecords;
use PHPUnit\Framework\TestCase;

final class BookRecordsTest extends TestCase
{
    private $bookRecords;

    private static $createdRecordId;

    protected function setUp(): void
    {
        $this->bookRecords = new BookRecords();
    }

    public function testRecordCanBeInserted(): void
    {
        $fakeData = [
            'id' => null,
            'first_name' => 'Tester',
            'last_name' => 'Inserter',
            'phone' => '704-232-445',
            'email' => 'tester-inserter-1@test.com',
            'address' => 'Unnamed street 21',
            'created_at' => Utils::nowTimestamp(),
            'updated_at' => null
        ];

        $bookRecord = BookRecord::fromArray($fakeData);

        self::$createdRecordId = $this->bookRecords->insert(
            $bookRecord
        );

        $this->assertIsNumeric(self::$createdRecordId);

        $this->assertTrue(self::$createdRecordId > 0);
    }

    public function testRecordCanBeRetrievedByField(): void
    {
        $recordByField = $this->bookRecords->byField('id', self::$createdRecordId);

        $this->assertSame(
            self::$createdRecordId,
            $recordByField->id
        );
    }

    public function testAllRecordsCanBeRetrieved(): void
    {
        $records = $this->bookRecords->all();

        $this->assertTrue(\count($records) > 0);
    }

    public function testRecordCanBeUpdated(): void
    {
        $recordByField = $this->bookRecords->byField('id', self::$createdRecordId);

        $recordByField->firstName = "Aang";

        $recordByField->lastName = "Avatar";

        $this->assertTrue(
            $this->bookRecords->update($recordByField)
        );

        $updatedRecordByField = $this->bookRecords->byField('id', self::$createdRecordId);

        $this->assertSame(
            $recordByField->firstName,
            $updatedRecordByField->firstName
        );

        $this->assertSame(
            $recordByField->lastName,
            $updatedRecordByField->lastName
        );
    }

    public function testRecordCanBeDeleted(): void
    {
        $this->assertTrue(
            $this->bookRecords->delete(self::$createdRecordId)
        );
    }
}
