<?php

namespace AddressBook\Dto;

/**
 * Book record DTO
 */
final class BookRecord
{
    public ?int $id;

    public string $firstName;

    public string $lastName;

    public string $phone;

    public string $email;

    public string $address;

    public string $createdAt;

    public ?string $updatedAt;

    public function __construct(?int $id, string $firstName, string $lastName, string $phone, string $email, string $address, string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;

        $this->firstName = $firstName;

        $this->lastName = $lastName;

        $this->phone = $phone;

        $this->email = $email;

        $this->address = $address;

        $this->createdAt = $createdAt;

        $this->updatedAt = $updatedAt;
    }

    /**
     * Create BookRecord DTO from array
     *
     * @param array $data
     *
     * @return BookRecord 
     */
    public static function fromArray(array $data): BookRecord
    {
        return new self(
            $data['id'],
            $data['first_name'],
            $data['last_name'],
            $data['phone'],
            $data['email'],
            $data['address'],
            $data['created_at'],
            $data['updated_at'],
        );
    }
}
