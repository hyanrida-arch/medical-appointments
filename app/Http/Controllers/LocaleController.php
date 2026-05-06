<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(string $locale)
    {
        if (in_array($locale, ['en', 'fr', 'ar'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}