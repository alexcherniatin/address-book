<?php

namespace AddressBook\Core;

/**
 * 
 * Basic MVC view
 * 
 */
final class View
{
    /**
     * Render view template
     *
     * @param string $viewPath Path to view for examplae "mail/index"
     * @param array $data Data accesible in view template
     * @param string $layout Layout template name
     *
     * @return void 
     */
    public static function render(string $viewPath, array $data = [], string $layout = 'layout'): void
    {
        require_once __DIR__ . '/../Views/' . $layout . '.php';
    }
}
