<?php

declare(strict_types=1);

use AddressBook\Core\Utils;
use AddressBook\Dto\BookRecord;
use AddressBook\Exceptions\AddressBookException;
use AddressBook\Exceptions\FormValidationException;
use AddressBook\Models\BookRecords;
use AddressBook\Services\BookRecordsService;
use AddressBook\Validators\BookRecordRequestValidator;
use PHPUnit\Framework\TestCase;

final class BookRecordsServiceTest extends TestCase
{
    private $validRequestInsertionData = [
        'first_name' => 'Tester',
        'last_name' => 'Test',
        'email' => 'abc@test.com',
        'phone' => '88005553535',
        'address' => 'Testera 1'
    ];

    public function testRecordCanBeCreatedFromServiceWithValidData(): void
    {
        /** @var BookRecords&\PHPUnit\Framework\MockObject\MockObject $bookRecordsMock */
        $bookRecordsMock = $this->getMockBuilder(BookRecords::class)
            ->onlyMethods(['insert', 'byField'])
            ->getMock();

        $bookRecordsMock
            ->expects($this->once())
            ->method('insert')
            ->willReturn(1);

        $bookRecordsMock
            ->expects($this->any())
            ->method('byField')
            ->willReturn(null);

        (new BookRecordsService($bookRecordsMock))->create($this->validRequestInsertionData, new BookRecordRequestValidator($bookRecordsMock));
    }

    public function testExceptionWillBeThrownIfInvalidDataOnInsert(): void
    {
        /** @var BookRecords&\PHPUnit\Framework\MockObject\MockObject $bookRecordsMock */
        $bookRecordsMock = $this->getMockBuilder(BookRecords::class)
            ->onlyMethods(['byField'])
            ->getMock();

        $bookRecordsMock
            ->expects($this->any())
            ->method('byField')
            ->willReturn(null);

        $this->expectException(FormValidationException::class);

        (new BookRecordsService($bookRecordsMock))->create([], new BookRecordRequestValidator($bookRecordsMock));
    }

    public function testExceptionWillBeThrownIfNotInsertedToDatabaseOnInsert(): void
    {
        /** @var BookRecords&\PHPUnit\Framework\MockObject\MockObject $bookRecordsMock */
        $bookRecordsMock = $this->getMockBuilder(BookRecords::class)
            ->onlyMethods(['byField', 'insert'])
            ->getMock();

        $bookRecordsMock
            ->expects($this->any())
            ->method('byField')
            ->willReturn(null);

        $bookRecordsMock
            ->expects($this->once())
            ->method('insert')
            ->willReturn(0);

        $this->expectException(AddressBookException::class);

        (new BookRecordsService($bookRecordsMock))->create($this->validRequestInsertionData, new BookRecordRequestValidator($bookRecordsMock));
    }

    public function testRecordCanBeUpdatedFromServiceWithValidData(): void
    {
        /** @var BookRecords&\PHPUnit\Framework\MockObject\MockObject $bookRecordsMock */
        $bookRecordsMock = $this->getMockBuilder(BookRecords::class)
            ->onlyMethods(['update', 'byField'])
            ->getMock();

        $bookRecordsMock
            ->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $data = [
            'id' => 1,
            'first_name' => 'Tester',
            'last_name' => 'Test',
            'email' => 'abc@test.com',
            'phone' => '88005553535',
            'address' => 'Testera 1',
            'created_at' => Utils::nowTimestamp(),
            'updated_at' => Utils::nowTimestamp(),
        ];

        $bookRecordsMock
            ->expects($this->any())
            ->method('byField')
            ->willReturn(
                BookRecord::fromArray($data)
            );

        (new BookRecordsService($bookRecordsMock))->update($data, new BookRecordRequestValidator($bookRecordsMock, BookRecordRequestValidator::ACTION_EDIT));
    }

    public function testRecordCanBeDeletedFromServiceWithValidData(): void
    {
        /** @var BookRecords&\PHPUnit\Framework\MockObject\MockObject $bookRecordsMock */
        $bookRecordsMock = $this->getMockBuilder(BookRecords::class)
            ->onlyMethods(['delete', 'byField'])
            ->getMock();

        $bookRecordsMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $data = [
            'id' => 1,
            'first_name' => 'Tester',
            'last_name' => 'Test',
            'email' => 'abc@test.com',
            'phone' => '88005553535',
            'address' => 'Testera 1',
            'created_at' => Utils::nowTimestamp(),
            'updated_at' => Utils::nowTimestamp(),
        ];

        $bookRecordsMock
            ->expects($this->any())
            ->method('byField')
            ->willReturn(
                BookRecord::fromArray($data)
            );

        (new BookRecordsService($bookRecordsMock))->delete($data, new BookRecordRequestValidator($bookRecordsMock, BookRecordRequestValidator::ACTION_DELETE));
    }
}
