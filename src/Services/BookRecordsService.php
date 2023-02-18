<?php

namespace AddressBook\Services;

use AddressBook\Core\Utils;
use AddressBook\Core\Validator;
use AddressBook\Dto\BookRecord;
use AddressBook\Exceptions\AddressBookException;
use AddressBook\Models\BookRecords;

class BookRecordsService
{
    /**
     * Validate and create new book record
     *
     * @param array $data Request data
     * @param Validator $validator The object which implements Validator inteface
     *
     * @throws AddressBookException
     * @throws FormValidationException
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

    /**
     * Validate and update book record
     *
     * @param array $data Request data
     * @param Validator $validator The object which implements Validator inteface
     *
     * @throws AddressBookException
     * @throws FormValidationException
     * 
     * @return void 
     */
    public function update(array $data, Validator $validator): void
    {
        $validatedData = $validator->validate($data);

        if (!(new BookRecords())->update(
            new BookRecord(
                $validatedData['bookRecord']->id,
                $validatedData['firstName'],
                $validatedData['lastName'],
                $validatedData['phone'],
                $validatedData['email'],
                $validatedData['address'],
                $validatedData['bookRecord']->createdAt,
                Utils::nowTimestamp()
            )
        )) {
            throw new AddressBookException("Wystąpił bląd przy edycji rekordu w bazie danych");
        }
    }

    /**
     * Validate and delete book record
     *
     * @param array $data Request data
     * @param Validator $validator The object which implements Validator inteface
     *
     * @throws AddressBookException
     * @throws FormValidationException
     * 
     * @return void 
     */
    public function delete(array $data, Validator $validator): void
    {
        $validatedData = $validator->validate($data);

        if (!(new BookRecords())->delete($validatedData['bookRecord']->id)) {
            throw new AddressBookException("Wystąpił bląd przy usunięciu rekordu z bazy danych");
        }
    }
}
