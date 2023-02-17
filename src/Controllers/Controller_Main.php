<?php

use AddressBook\Builders\BookRecordsBuilder;
use AddressBook\Core\Controller;
use AddressBook\Core\View;
use AddressBook\Models\BookRecords;

class Controller_Main extends Controller
{
    /**
     * Main page /
     * 
     * @return void 
     */
    public function index(): void
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
