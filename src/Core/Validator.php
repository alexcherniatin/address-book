<?php

namespace AddressBook\Core;

interface Validator
{
    /**
     * Validate given data
     *
     * @param array $data
     *
     * @return array Validated data 
     */
    public function validate(array $data): array;
}
