<?php

namespace AddressBook\Exceptions;

use Exception;
use Throwable;

/**
 * Exception to throw when form field is invalid
 *
 */
class FormValidationException extends Exception
{
    /**
     * Form field name
     *
     * @var string 
     */
    private string $formFieldName;

    public function __construct(string $message, string $formFieldName, int $code = 0, Throwable $previous = null)
    {
        $this->formFieldName = $formFieldName;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get exception form field name
     *
     * @return string 
     */
    public function getFormFieldName(): string
    {
        return $this->formFieldName;
    }
}
