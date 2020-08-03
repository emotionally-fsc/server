<?php

namespace Emotionally\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public const AVAILABLE_LANGUAGES = ['en', 'it'];

    public function setLanguage($language, Request $request)
    {
        if (!in_array($language, self::AVAILABLE_LANGUAGES)) {
            $language = config('app.fallback_locale');
        }
        \Session::put('locale', $language);
        \App::setLocale($language);
        return back();
    }
}
