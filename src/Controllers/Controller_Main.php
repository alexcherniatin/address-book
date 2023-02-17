<?php

use AddressBook\Core\Controller;
use AddressBook\Core\View;
use AddressBook\Models\BookRecord;

class Controller_Main extends Controller
{
    public function index()
    {
        $model = new BookRecord();
        
        View::render('main/index');
    }
}
