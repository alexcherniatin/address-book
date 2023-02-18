<?php

namespace AddressBook\Validators;

use AddressBook\Exceptions\FormValidationException;

abstract class AbstractValidator
{
    /**
     * Validate string
     *
     * @param string $text String to validate
     * @param int $filter The ID of the filter to apply. 
     * @param string $fieldName The name of the field 
     * @param int $maxLength Max string length
     * @param int $minLength Min string length
     * 
     * @throws FormValidationException
     *
     * @return string Validated string 
     */
    protected function validateString(string $text, int $filter, string $fieldName, string $formFieldName, int $maxLength = 255, int $minLength = 2): string
    {
        $validatedString = filter_var($text, $filter);

        if ($validatedString === false) {
            throw new FormValidationException(sprintf('Wpisz %s', strtolower($fieldName)), $formFieldName);
        }

        $length = \strlen($validatedString);

        if ($length < $minLength) {
            throw new FormValidationException(sprintf('Wpisz %s', strtolower($fieldName)), $formFieldName);
        }

        if ($length > $maxLength) {
            throw new FormValidationException(sprintf('Maksymalna ilość znaków dla pola "%s" %d', $fieldName, $maxLength), $formFieldName);
        }

        return $validatedString;
    }
}
