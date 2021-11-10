<?php

namespace App\Actions\Todo;


use App\Models\User;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
class BrowseTodo
{
    use AsAction;

    public function handle(): array
    {
        /** @var User $user */
        $user = auth()->user();
        if (is_null($user)) {
            abort(SymfonyResponse::HTTP_UNAUTHORIZED, Response::$statusTexts[SymfonyResponse::HTTP_UNAUTHORIZED]);
        }
        $todos = $user->todos()->with('items')->get();
        return [
            'data' => $todos
        ];
    }
}
