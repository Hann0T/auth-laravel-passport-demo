<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassportClientsController extends Controller
{
    public function index(Request $request)
    {
        return view('passport.clients', [
            'clients' => $request->user()->clients,
        ]);
    }
}
