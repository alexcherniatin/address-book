<?php

declare(strict_types=1);

use AddressBook\Exceptions\FormValidationException;
use AddressBook\Models\BookRecords;
use PHPUnit\Framework\TestCase;
use AddressBook\Validators\BookRecordRequestValidator;

final class BookRecordRequestValidatorTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        $this->validator = (new BookRecordRequestValidator(new BookRecords()));
    }

    public function testValidateThrowsExceptionOnEmptyData(): void
    {
        $this->expectException(FormValidationException::class);

        $this->validator->validate([]);
    }

    public function testValidateThrowsExceptionOnEmptyString(): void
    {
        $this->expectException(FormValidationException::class);

        $this->validator->validate([
            'first_name' => '',
            'last_name' => 'Test last',
            'email' => 'alex@test.com',
            'phone' => '888-323-324',
            'address' => 'Test 1, 03-223'
        ]);
    }

    public function testValidateSuccessOnValidData(): void
    {
        $validatedData = $this->validator->validate([
            'first_name' => 'Alex<script>alert(1)</script>', //xss code
            'last_name' => 'Test last',
            'email' => 'alex@test.com',
            'phone' => '888-323-324adasdasdas', //bad phone number
            'address' => 'Test 1, 03-223'
        ]);

        $this->assertSame(
            [
                'firstName' => 'Alex&#60;script&#62;alert(1)&#60;/script&#62;',
                'lastName' => 'Test last',
                'email' => 'alex@test.com',
                'phone' => '888-323-324',
                'address' => 'Test 1, 03-223'
            ],
            $validatedData
        );
    }
}
