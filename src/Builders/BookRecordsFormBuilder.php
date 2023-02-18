<?php

namespace AddressBook\Builders;

use AddressBook\Dto\BookRecord;

class BookRecordsFormBuilder
{
    public function form(string $action, ?BookRecord $bookRecord): string
    {
        $submitButtonText = (\is_null($bookRecord)) ? 'Dodaj' : 'Zapisz zmiany';

        return '
        <form action="' . $action . '" class="form row g-2 needs-validation" id="book-records-form" novalidate>
            <div class="col-md-6 col-xs-12">
                <label for="fist_name" class="form-label">Imię</label>
                <input class="form-control" type="text" name="fist_name" id="fist_name" value="' . ($bookRecord->firstName ?? '') . '" required>

                <div class="invalid-feedback">
                    Wpisz imię!
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <label for="last_name" class="form-label">Nazwisko</label>
                <input class="form-control" type="text" name="last_name" id="last_name" value="' . ($bookRecord->lastName ?? '') . '" required>
                
                <div class="invalid-feedback">
                    Wpisz nazwisko!
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <label for="email" class="form-label">E-mail</label>
                <input class="form-control" type="email" name="email" id="email" value="' . ($bookRecord->email ?? '') . '" required>
                
                <div class="invalid-feedback">
                    Wpisz e-mail!
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <label for="phone" class="form-label">Numer telefonu</label>
                <input class="form-control" type="text" name="phone" id="phone" value="' . ($bookRecord->phone ?? '') . '" required>
                
                <div class="invalid-feedback">
                    Wpisz numer telefonu!
                </div>
            </div>

            <div class="col-12">
                <label for="address" class="form-label">Adres fizyczny</label>
                <textarea name="address" id="address" class="form-control" cols="3" rows="3" required>' . ($bookRecord->address ?? '') . '</textarea>
                
                <div class="invalid-feedback">
                    Wpisz adres fizyczny!
                </div>
            </div>

            <div class="form-errors"></div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">' . $submitButtonText . '</button>
            </div>
        </form>';
    }
}
