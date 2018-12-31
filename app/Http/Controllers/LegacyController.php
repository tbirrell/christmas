<?php

namespace App\Http\Controllers;


class LegacyController extends Controller
{
    public function handle($path = '/index.php')
    {
        dump($path);
        $legacy_path = base_path("legacy/public{$path}");
        dump($legacy_path);
        if (file_exists($legacy_path)) {
            require_once base_path('legacy/utilities/boot.php');
            require_once $legacy_path;
        }
    }
}
