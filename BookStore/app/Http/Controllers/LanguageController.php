<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Ganti bahasa yang aktif dan simpan di Session.
     */
    public function switchLang(Request $request, $lang)
    {
        // Pastikan bahasa yang dipilih ada di daftar aman (id atau en)
        if (in_array($lang, ['id', 'en'])) {

            // Simpan bahasa yang dipilih ke Session
            Session::put('locale', $lang);

            // Atur bahasa untuk request saat ini
            App::setLocale($lang);
        }

        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
