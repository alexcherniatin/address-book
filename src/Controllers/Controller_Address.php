<?php

use AddressBook\Builders\BookRecordsFormBuilder;
use AddressBook\Core\Controller;
use AddressBook\Core\View;
use AddressBook\Exceptions\AddressBookException;
use AddressBook\Exceptions\FormValidationException;
use AddressBook\Models\BookRecords;
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
            'address/add',
            [
                'form' => (new BookRecordsFormBuilder())->form(
                    '/address/create/',
                    null
                )
            ]
        );
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->response(['message' => 'Method not allowed'], 405);
        }

        try {
            (new BookRecordsService())->create($_POST, new BookRecordRequestValidator(new BookRecords()));
        } catch (AddressBookException $th) {
            return $this->response(['message' => $th->getMessage(), 'field' => 'form'], 400);
        } catch (FormValidationException $th) {
            return $this->response(['message' => $th->getMessage(), 'field' => $th->getFormFieldName()], 400);
        } catch (\Throwable $th) {
            return $this->response(['message' => 'Wystąpił błąd'], 500);
        }

        return $this->response(['message' => 'Adres dodano do książki adresowej']);
    }
}
