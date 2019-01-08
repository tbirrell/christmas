<?php

namespace App\Http\Controllers;


class LegacyController extends Controller
{
    public function handle($path = '/index')
    {
        $legacy_path = base_path("legacy/public/{$path}.php");
        if (file_exists($legacy_path)) {
            require_once base_path('legacy/utilities/boot.php');
            require_once $legacy_path;
        }
    }
}
