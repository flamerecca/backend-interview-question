<?php

namespace App\Actions\Auth;

use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Refresh
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
        $token = Str::random(60);
        auth()->user()->setRememberToken($token);
        return [
            'access_token' => $token
        ];
    }
}
