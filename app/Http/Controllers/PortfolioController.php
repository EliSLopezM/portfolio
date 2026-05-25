<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    private function data(): array
    {
        return config("portfolio");
    }
    public function index()
    {
        return view("pages.home",       ["portfolio" => $this->data()]);
    }
    public function proyectos()
    {
        return view("pages.proyectos",  ["portfolio" => $this->data()]);
    }
    public function stack()
    {
        return view("pages.stack",      ["portfolio" => $this->data()]);
    }
    public function experiencia()
    {
        return view("pages.experiencia", ["portfolio" => $this->data()]);
    }
    public function contactView()
    {
        return view("pages.contacto",   ["portfolio" => $this->data()]);
    }
    public function contact(Request $request)
    {
        $validated = $request->validate([
            'nombre'  => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'asunto'  => 'nullable|string|max:200',
            'mensaje' => 'required|string|max:2000',
        ]);

        \App\Models\Message::create($validated);

        return back()->with('success', '¡Mensaje enviado! Te responderé pronto.');
    }
}
