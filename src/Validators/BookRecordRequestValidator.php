<?php

namespace AddressBook\Validators;

use AddressBook\Core\Validator;

class BookRecordRequestValidator implements Validator
{
    /**
     * Validated data
     *
     * @var array 
     */
    private $validatedData = [];

    /**
     * Is edit flag
     * 
     * If true will validate existing record
     *
     * @var bool 
     */
    private $isEdit = false;

    public function __construct(bool $isEdit = false)
    {
        $this->isEdit = $isEdit;
    }

    public function validate(array $data): array
    {
        //TODO

        return $this->validatedData;
    }
}
