<?php

namespace App\Actions\Auth;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Token
{
    use AsAction;

    /*
     * @return array{access_token: string}
     */
    public function handle(): array
    {
        if (!auth()->check()) {
            abort(SymfonyResponse::HTTP_UNAUTHORIZED, Response::$statusTexts[SymfonyResponse::HTTP_UNAUTHORIZED]);
        }
        $payload = auth()->getPayload();
        $tokenStatus = collect([
            'expired_at' => $payload->get('exp'),
            'not_before_at' => $payload->get('nbf'),
            'issued_at' => $payload->get('iat'),
        ])
            ->map(fn($value) => Carbon::createFromTimestamp($value)->toIso8601ZuluString());
        return $tokenStatus->toArray();
    }
}
