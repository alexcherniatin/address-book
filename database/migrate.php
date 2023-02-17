<?php

use AddressBook\Models\BookRecords;

require __DIR__ . '/../vendor/autoload.php';

(new BookRecords())->migrate();
