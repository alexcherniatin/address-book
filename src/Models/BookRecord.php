<?php

namespace AddressBook\Models;

use AddressBook\Core\Model;

final class BookRecord extends Model
{
    public function migrate()
    {
        $query = "CREATE TABLE book_records (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name TEXT NOT NULL,
            last_name TEXT NOT NULL,
            address TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            phone TEXT NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at TIMESTAMP NULL
        );";
        $this->db->query($query);
        $this->db->execute();
    }
}
