<?php

use AddressBook\Models\BookRecord;

require __DIR__ . '/../vendor/autoload.php';

(new BookRecord())->migrate();
