<?php

namespace AddressBook\Core;

/**
 * Basic abstact model
 *
 */
abstract class Model
{
    protected $db;

    /**
     *Constructor, init database
     *
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
