<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio = config('portfolio');
        return view('portfolio.index', compact('portfolio'));
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'nombre'  => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'asunto'  => 'nullable|string|max:200',
            'mensaje' => 'required|string|max:2000',
        ]);

        // Envía el email — configura MAIL_* en .env
        // Mail::to(config('portfolio.email'))->send(new \App\Mail\ContactMail($validated));

        return back()->with('success', '¡Mensaje enviado! Te responderé pronto.');
    }
}
