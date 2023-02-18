<?php

namespace AddressBook\Models;

use AddressBook\Core\Model;
use AddressBook\Dto\BookRecord;
use AddressBook\Exceptions\AddressBookException;

/**
 * Class for manipulating book records data in database
 */
final class BookRecords extends Model
{
    /**
     * Allowed table search fields
     *
     * @var array 
     */
    private array $allowedSearchFields = [
        'id',
        'first_name',
        'last_name',
        'address',
        'email',
        'phone',
    ];

    /**
     * Create table
     *
     * @return void 
     */
    public function migrate(): void
    {
        $query = "CREATE TABLE IF NOT EXISTS book_records (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            address VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(50) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at TIMESTAMP NULL
        );";

        $this->db->query($query);

        $this->db->execute();
    }

    /**
     * Insert new book record
     *
     * @param BookRecord $bookRecord Book record dto
     *
     * @return int Created record id
     */
    public function insert(BookRecord $bookRecord): int
    {
        $query = "INSERT INTO book_records
        (first_name,last_name,address,email,phone,created_at)
        VALUES
        (:first_name,:last_name,:address,:email,:phone,:created_at)";
        $this->db->query($query);
        $this->db->bind(':first_name', $bookRecord->firstName);
        $this->db->bind(':last_name', $bookRecord->lastName);
        $this->db->bind(':address', $bookRecord->address);
        $this->db->bind(':email', $bookRecord->email);
        $this->db->bind(':phone', $bookRecord->phone);
        $this->db->bind(':created_at', $bookRecord->createdAt);
        $result = $this->db->execute();
        return ($result) ? $this->db->lastInsertId() : 0;
    }

    /**
     * Update book record
     *
     * @param BookRecord $bookRecord Book record dto
     *
     * @return bool
     */
    public function update(BookRecord $bookRecord): bool
    {
        $query = "UPDATE book_records
        SET
        first_name = :first_name,
        last_name = :last_name,
        address = :address,
        email = :email,
        phone = :phone,
        updated_at = :updated_at
        WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':first_name', $bookRecord->firstName);
        $this->db->bind(':last_name', $bookRecord->lastName);
        $this->db->bind(':address', $bookRecord->address);
        $this->db->bind(':email', $bookRecord->email);
        $this->db->bind(':phone', $bookRecord->phone);
        $this->db->bind(':updated_at', $bookRecord->updatedAt);
        $this->db->bind(':id', $bookRecord->id);
        $result = $this->db->execute();
        return $result;
    }

    /**
     * Get all records
     *
     * @return array<BookRecord>
     */
    public function all(): array
    {
        $query = "SELECT id,first_name,last_name,address,phone,email,created_at,updated_at
        FROM book_records
        ORDER BY id DESC
        LIMIT 500";
        $this->db->query($query);
        $result = $this->db->resultset();
        return ($result) ? array_map(fn ($row) => BookRecord::fromArray($row), $result) : [];
    }

    /**
     * Get record by field
     *
     * @param string $field The name of the field
     * @param int|string $value The value of the field
     *
     * @throws AddressBookException
     * 
     * @return ?BookRecord
     */
    public function byField(string $field, int|string $value): ?BookRecord
    {
        if (!in_array($field, $this->allowedSearchFields)) {
            throw new AddressBookException("Invalid field name");
        }

        $query = "SELECT id,first_name,last_name,address,phone,email,created_at,updated_at
        FROM book_records
        WHERE " . $field . " = :value
        LIMIT 1";
        $this->db->query($query);
        $this->db->bind(':value', $value);
        $result = $this->db->result();
        return ($result) ? BookRecord::fromArray($result) : null;
    }

    /**
     * Delete by id
     *
     * @param int $id The id of book record
     *
     * @return bool 
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM book_records
        WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $result = $this->db->execute();
        return $result;
    }
}
