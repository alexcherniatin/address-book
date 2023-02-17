<?php

namespace AddressBook\Core;

final class View
{
    public static function render(string $viewPath, array $data = [], string $layout = 'layout'): void
    {
        require_once __DIR__ . '/../Views/' . $layout . '.php';
    }
}
