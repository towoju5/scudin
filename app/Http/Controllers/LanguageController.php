<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    //
    public function swap($locale)
    {
        // available language in template array
        $availLocale = ['en', 'fr', 'de', 'pt', 'es'];
        // check for existing language
        if (in_array($locale, $availLocale)) {
            // session()->put('locale', $locale);
            app()->setLocale($locale);
            session()->put('locale', $locale);
            return redirect()->back()->with('message', __('Language update successfully'));
        }
        return redirect()->back()->with('message', __('Unable to switch language'));
    }
}
