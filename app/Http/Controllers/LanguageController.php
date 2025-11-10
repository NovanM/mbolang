<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'id'])) {
            abort(400);
        }
        
        // Store locale in session
        session(['locale' => $locale]);
        
        // Redirect back
        return redirect()->back();
    }
}
