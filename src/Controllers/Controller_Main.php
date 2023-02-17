<?php

use AddressBook\Builders\BookRecordsBuilder;
use AddressBook\Core\Controller;
use AddressBook\Core\View;
use AddressBook\Models\BookRecords;

class Controller_Main extends Controller
{
    public function index()
    {
        View::render(
            'main/index',
            [
                'bookRecordsList' => (new BookRecordsBuilder())->buildList(
                    (new BookRecords())->all()
                )
            ]
        );
    }
}
