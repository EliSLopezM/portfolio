<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        // Verificación reCAPTCHA — solo se activa si hay secret key configurada.
        $recaptchaSecret = config('services.recaptcha.secret_key');
        if ($recaptchaSecret) {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $recaptchaSecret,
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            if (! $response->ok()
                || ! $response->json('success')
                || $response->json('action') !== 'contact'
                || (float) $response->json('score', 0) < 0.5) {
                return back()
                    ->withErrors(['recaptcha' => 'No pudimos verificar el reCAPTCHA. Inténtalo de nuevo.'])
                    ->withInput();
            }
        }

        \App\Models\Message::create($validated);

        try {
            Mail::to(config('portfolio.email'))->send(new ContactMail($validated));
        } catch (\Throwable $e) {
            // El mensaje ya quedó guardado en base de datos aunque el correo falle.
            Log::error('Error enviando correo de contacto: ' . $e->getMessage());
        }

        return back()->with('success', '¡Mensaje enviado! Te responderé pronto.');
    }
}
