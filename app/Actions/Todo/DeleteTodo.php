<?php

namespace App\Actions\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class DeleteTodo
{
    use AsAction;

    public function handle($todoId): Response
    {
        /** @var User $user */
        $user = auth()->user();
        if (is_null($user)) {
            abort(SymfonyResponse::HTTP_UNAUTHORIZED, Response::$statusTexts[SymfonyResponse::HTTP_UNAUTHORIZED]);
        }
        $todo = Todo::query()
            ->where('id', $todoId)
            ->with('items')
            ->firstOrFail();
        if (!$todo->delete()) {
            abort(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR, "Delete Todo Fail");
        }
        return response(status: SymfonyResponse::HTTP_NO_CONTENT);
    }
}
