<?php

use AddressBook\Builders\BookRecordsFormBuilder;
use AddressBook\Core\Controller;
use AddressBook\Core\Router;
use AddressBook\Core\View;
use AddressBook\Exceptions\AddressBookException;
use AddressBook\Exceptions\FormValidationException;
use AddressBook\Models\BookRecords;
use AddressBook\Services\BookRecordsService;
use AddressBook\Validators\BookRecordRequestValidator;

class Controller_Address extends Controller
{
    /**
     * Add address page /address/add/
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
                ),
                'meta' => [
                    'title' => 'Dodaj adres'
                ]
            ]
        );
    }

    /**
     * Edit address page /address/edit/{id}/
     * 
     * @return void 
     */
    public function edit(): void
    {
        $id = Router::getUrlPart(3);

        if (is_null($id)) {
            Router::error404();
        }

        if (!$bookRecord = (new BookRecords())->byField('id', $id)) {
            Router::error404();
        }

        View::render(
            'address/edit',
            [
                'form' => (new BookRecordsFormBuilder())->form(
                    '/address/update/',
                    $bookRecord
                ),
                'meta' => [
                    'title' => 'Edytuj adres'
                ]
            ]
        );
    }

    /**
     * Create address /address/create/
     * 
     * @return void 
     */
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

        return $this->response(['message' => 'Adres dodano do książki adresowej', 'resetForm' => true]);
    }

    /**
     * Update address /address/update/
     * 
     * @return void 
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->response(['message' => 'Method not allowed'], 405);
        }

        try {
            (new BookRecordsService())->update($_POST, new BookRecordRequestValidator(new BookRecords(), BookRecordRequestValidator::ACTION_EDIT));
        } catch (AddressBookException $th) {
            return $this->response(['message' => $th->getMessage(), 'field' => 'form'], 400);
        } catch (FormValidationException $th) {
            return $this->response(['message' => $th->getMessage(), 'field' => $th->getFormFieldName()], 400);
        } catch (\Throwable $th) {
            return $this->response(['message' => 'Wystąpił błąd'], 500);
        }

        return $this->response(['message' => 'Zmiany zapisane', 'resetForm' => false]);
    }

    /**
     * Delete address /address/delete/
     * 
     * @return void 
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->response(['message' => 'Method not allowed'], 405);
        }

        try {
            (new BookRecordsService())->delete($_POST, new BookRecordRequestValidator(new BookRecords(), BookRecordRequestValidator::ACTION_DELETE));
        } catch (AddressBookException $th) {
            return $this->response(['message' => $th->getMessage(), 'field' => 'form'], 400);
        } catch (FormValidationException $th) {
            return $this->response(['message' => $th->getMessage(), 'field' => $th->getFormFieldName()], 400);
        } catch (\Throwable $th) {
            return $this->response(['message' => 'Wystąpił błąd'], 500);
        }

        return $this->response(['message' => 'Adres usunięto z książki adresowej']);
    }
}
