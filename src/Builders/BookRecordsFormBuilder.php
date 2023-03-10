<?php

namespace AddressBook\Builders;

use AddressBook\Dto\BookRecord;

class BookRecordsFormBuilder
{
    /**
     * Form invalid feedback messages
     *
     * @var array 
     */
    private $formErrorMessages = [
        'first_name' => 'Wpisz imię!',
        'last_name' => 'Wpisz nazwisko!',
        'email' => 'Wpisz e-mail w prawidłowym formacie np: alex@domain.com!',
        'phone' => 'Wpisz numer telefonu np: +48555666777!',
        'address' => 'Wpisz adres fizyczny!'
    ];

    /**
     * Build html form for adding and editing book records
     *
     * @param string $action Form action
     * @param ?BookRecord $bookRecord Book record dto
     *
     * @return string 
     */
    public function form(string $action, ?BookRecord $bookRecord): string
    {
        if (\is_null($bookRecord)) {
            $submitButtonText = 'Dodaj';

            $idInput = '';
        } else {
            $submitButtonText = 'Zapisz zmiany';

            $idInput = '<input type="hidden" name="id" value="' . $bookRecord->id . '">';
        }

        return '
        <form action="' . $action . '" class="form row g-2 needs-validation" id="book-records-form" novalidate>
            <div class="col-md-6 col-xs-12">
                <label for="first_name" class="form-label">Imię</label>
                <input class="form-control" type="text" name="first_name" id="first_name" placeholder="Wpisz imię np: Oleksandr" value="' . ($bookRecord->firstName ?? '') . '" required>

                <div class="invalid-feedback" data-default="' . $this->formErrorMessages['first_name'] . '">
                    ' . $this->formErrorMessages['first_name'] . '
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <label for="last_name" class="form-label">Nazwisko</label>
                <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Wpisz imię np: Cherniatin" value="' . ($bookRecord->lastName ?? '') . '" required>
                
                <div class="invalid-feedback" data-default="' . $this->formErrorMessages['last_name'] . '">
                    ' . $this->formErrorMessages['last_name'] . '
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <label for="email" class="form-label">E-mail</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Wpisz e-mail np: person@domain.com" value="' . ($bookRecord->email ?? '') . '" required>
                
                <div class="invalid-feedback" data-default="' . $this->formErrorMessages['email'] . '">
                    ' . $this->formErrorMessages['email'] . '
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <label for="phone" class="form-label">Numer telefonu</label>
                <input class="form-control" type="tel" name="phone" id="phone" placeholder="Wpisz numer telefonu np: +48555666777" value="' . ($bookRecord->phone ?? '') . '" required>
                
                <div class="invalid-feedback" data-default="' . $this->formErrorMessages['phone'] . '">
                    ' . $this->formErrorMessages['phone'] . '
                </div>
            </div>

            <div class="col-12">
                <label for="address" class="form-label">Adres fizyczny</label>
                <textarea name="address" id="address" class="form-control" cols="3" rows="3" placeholder="Wpisz adres fizyczny" required>' . ($bookRecord->address ?? '') . '</textarea>
                
                <div class="invalid-feedback" data-default="' . $this->formErrorMessages['address'] . '">
                    ' . $this->formErrorMessages['address'] . '
                </div>
            </div>

            <div class="form-info"></div>

            <div class="col-12">
                ' . $idInput . '
                <button class="btn btn-primary" type="submit">
                    <span class="default-state">' . $submitButtonText . '</span>

                    <span class="loading-state d-none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Ładowanie...
                    </span>
                </button>
            </div>
        </form>';
    }
}
