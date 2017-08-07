<?php

namespace App\Http\Controllers;

use App\Crypto\Rand;

class MetrixController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display KeyPad page for creating new KeyPad.
     */
    public function new()
    {
        $passphrase_metrix = Rand::metrix();

        return view('utils.metrix', [
            'passphrase_metrix' => $passphrase_metrix,
            ]);
    }
}
