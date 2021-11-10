<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class GetTodo
{
    use AsAction;

    public function handle($todoId): Model
    {
        /** @var User $user */
        $user = auth()->user();
        if (is_null($user)) {
            abort(SymfonyResponse::HTTP_UNAUTHORIZED, Response::$statusTexts[SymfonyResponse::HTTP_UNAUTHORIZED]);
        }
        return Todo::query()->where('id', $todoId)->with('items')->firstOrFail();
    }
}
