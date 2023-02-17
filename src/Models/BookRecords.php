<?php

namespace AddressBook\Models;

use AddressBook\Core\Model;
use AddressBook\Dto\BookRecord;

final class BookRecords extends Model
{
    private $allowedSearchFields = [
        'id',
        'first_name',
        'last_name',
        'address',
        'email',
        'phone',
    ];

    public function migrate()
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

    public function all(): array
    {
        $query = "SELECT id,first_name,last_name,address,phone,email,created_at,updated_at
        FROM book_records
        ORDER BY id DESC";
        $this->db->query($query);
        $result = $this->db->resultset();
        return ($result) ? array_map(fn ($row) => BookRecord::fromArray($row), $result) : [];
    }

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
}
