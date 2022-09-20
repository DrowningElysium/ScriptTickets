<?php

namespace App\Http\Controllers;

class AppController {
    public function __invoke()
    {
        return response()->view('app');
    }
}