<?php

namespace AddressBook\Validators;

use AddressBook\Core\Validator;
use AddressBook\Exceptions\FormValidationException;
use AddressBook\Models\BookRecords;

class BookRecordRequestValidator extends AbstractValidator implements Validator
{
    /**
     * Data to validate
     *
     * @var array 
     */
    private $data = [];

    /**
     * Validated data
     *
     * @var array 
     */
    private $validatedData = [];

    private BookRecords $model;

    /**
     * Is edit flag
     * 
     * If true will validate existing record
     *
     * @var bool 
     */
    private $isEdit = false;

    public function __construct(BookRecords $bookRecords, bool $isEdit = false)
    {
        $this->model = $bookRecords;

        $this->isEdit = $isEdit;
    }

    public function validate(array $data): array
    {
        $this->data = $data;

        if ($this->isEdit) {
            $this->validateId();
        }

        $this->validateFirstName();

        $this->validateLastName();

        $this->validatePhone();

        $this->validateEmail();

        $this->validateAddress();

        return $this->validatedData;
    }

    /**
     * Validate book record id
     *
     * @throws FormValidationException
     *
     * @return void 
     */
    private function validateId(): void
    {
        $field = 'id';

        if (!isset($this->data[$field])) {
            throw new FormValidationException('Brak identyfikatoru', $field);
        }

        $this->validatedData['bookRecord'] = $this->model->byField($field, $this->data[$field]);

        if (\is_null($this->validatedData['bookRecord'])) {
            throw new FormValidationException('Wpis o podanym identyfikatorze nie istnieje', $field);
        }
    }

    /**
     * Validate first name
     *
     * @throws FormValidationException
     *
     * @return void 
     */
    private function validateFirstName(): void
    {
        $field = 'first_name';

        if (!isset($this->data[$field])) {
            throw new FormValidationException('Wpisz imię', $field);
        }

        $this->validatedData['firstName'] = $this->validateString(
            $this->data[$field],
            FILTER_SANITIZE_SPECIAL_CHARS,
            'Imię',
            $field
        );
    }

    /**
     * Validate last name
     *
     * @throws FormValidationException
     *
     * @return void 
     */
    private function validateLastName(): void
    {
        $field = 'last_name';

        if (!isset($this->data[$field])) {
            throw new FormValidationException('Wpisz nazwisko', $field);
        }

        $this->validatedData['lastName'] = $this->validateString(
            $this->data[$field],
            FILTER_SANITIZE_SPECIAL_CHARS,
            'Nazwisko',
            $field
        );
    }

    /**
     * Validate phone number
     *
     * @throws FormValidationException
     *
     * @return void 
     */
    private function validatePhone(): void
    {
        $field = 'phone';

        if (!isset($this->data[$field])) {
            throw new FormValidationException('Wpisz numer telefonu', $field);
        }

        $this->validatedData[$field] = $this->validateString(
            $this->data[$field],
            FILTER_SANITIZE_SPECIAL_CHARS,
            'Numer telefonu',
            $field,
            50
        );

        //check is phone unique

        $bookRecord = $this->model->byField($field, $this->validatedData[$field]);

        if (\is_null($bookRecord)) {
            return;
        }

        if ($this->isEdit && $bookRecord->id == ($this->data['id'] ?? -1)) {
            return;
        }

        throw new FormValidationException('Wpis o podanym numerze telefonu już jest w książce', $field);
    }

    /**
     * Validate e-mail
     *
     * @throws FormValidationException
     *
     * @return void 
     */
    private function validateEmail(): void
    {
        $field = 'email';

        if (!isset($this->data[$field])) {
            throw new FormValidationException('Wpisz e-mail', $field);
        }

        $this->validatedData[$field] = $this->validateString(
            $this->data[$field],
            FILTER_SANITIZE_EMAIL,
            'E-mail',
            $field
        );

        //check is e-mail unique

        $bookRecord = $this->model->byField($field, $this->validatedData[$field]);

        if (\is_null($bookRecord)) {
            return;
        }

        if ($this->isEdit && $bookRecord->id == ($this->data['id'] ?? -1)) {
            return;
        }

        throw new FormValidationException('Wpis o podanym adresie e-mail już jest w książce', $field);
    }

    /**
     * Validate address
     *
     * @throws FormValidationException
     *
     * @return void 
     */
    private function validateAddress(): void
    {
        $field = 'address';

        if (!isset($this->data[$field])) {
            throw new FormValidationException('Wpisz adres', $field);
        }

        $this->validatedData[$field] = $this->validateString(
            $this->data[$field],
            FILTER_SANITIZE_SPECIAL_CHARS,
            'Adres',
            $field
        );
    }
}
