<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaVerifier
{
    public const MIN_SCORE = 0.5;

    public function configured(): bool
    {
        return filled(config('services.recaptcha.secret_key'));
    }

    /**
     * Verifica un token reCAPTCHA v3 para una acción concreta.
     *
     * @return array{ok: bool, score: float|null}
     */
    public function verify(?string $token, string $action, ?string $ip): array
    {
        if (blank($token)) {
            return ['ok' => false, 'score' => null];
        }

        try {
            $response = Http::asForm()->timeout(6)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $token,
                'remoteip' => $ip,
            ]);
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA no disponible.', ['error' => $e->getMessage()]);

            return ['ok' => false, 'score' => null];
        }

        $score = $response->json('score');

        return [
            'ok' => $response->ok()
                && $response->json('success') === true
                && $response->json('action') === $action
                && (float) $score >= self::MIN_SCORE,
            'score' => $score === null ? null : (float) $score,
        ];
    }
}
