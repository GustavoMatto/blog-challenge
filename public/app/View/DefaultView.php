<?php

namespace Desafiobis2bis\App\View;

use Desafiobis2bis\App\View\ViewInterface;

class DefaultView implements ViewInterface 
{
    public function render(string $view): string 
    {
        ob_start();
        include __DIR__ . '/frontend/' . $view;
        return ob_get_clean();
    }
}