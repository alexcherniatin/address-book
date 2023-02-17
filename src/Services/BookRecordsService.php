<?php

namespace AddressBook\Services;

use AddressBook\Core\Utils;
use AddressBook\Core\Validator;
use AddressBook\Dto\BookRecord;
use AddressBook\Models\AddressBookException;
use AddressBook\Models\BookRecords;

class BookRecordsService
{
    /**
     * Validate and create new book record
     *
     * @param array $data Reqeust data
     * @param Validato $validator Validator class
     *
     * @throws AddressBookException
     * 
     * @return void 
     */
    public function create(array $data, Validator $validator): void
    {
        $validatedData = $validator->validate($data);

        if (!(new BookRecords())->insert(
            new BookRecord(
                null,
                $validatedData['firstName'],
                $validatedData['lastName'],
                $validatedData['phone'],
                $validatedData['email'],
                $validatedData['address'],
                Utils::nowTimestamp(),
                null
            )
        )) {
            throw new AddressBookException("Wystąpił bląd przy dodaniu rekordu do bazy danych");
        }
    }
}
