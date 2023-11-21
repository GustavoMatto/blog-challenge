<?php

namespace Desafiobis2bis\App\View;

interface ViewInterface {
    public function render(string $view): string;
}