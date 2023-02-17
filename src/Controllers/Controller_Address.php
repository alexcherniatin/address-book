<?php

use AddressBook\Core\Controller;
use AddressBook\Core\View;
use AddressBook\Models\AddressBookException;
use AddressBook\Services\BookRecordsService;
use AddressBook\Validators\BookRecordRequestValidator;

class Controller_Address extends Controller
{
    /**
     * Add address page /adress/add/
     * 
     * @return void 
     */
    public function add(): void
    {
        View::render(
            'address/add'
        );
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->response(['message' => 'Method not allowed'], 405);
        }

        try {
            (new BookRecordsService())->create($_POST, new BookRecordRequestValidator());
        } catch (AddressBookException $th) {
            return $this->response(['message' => $th->getMessage()], 400);
        } catch (\Throwable $th) {
            return $this->response(['message' => 'Wystąpił błąd'], 500);
        }

        return $this->response(['message' => 'Adres dodano do książki adresowej']);
    }
}
