<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Me
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
        /** @var User $user */
        $user = auth()->user();
        return [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ];
    }
}
