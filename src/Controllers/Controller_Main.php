<?php

use AddressBook\Core\Controller;

class Controller_Main extends Controller
{
    public function index()
    {
        return $this->response([
            'message' => '123'
        ]);
    }
}
