<?php

namespace App\Actions\Todo\Item;

use App\Models\TodoItem;
use App\Models\User;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class DeleteItem
{
    use AsAction;

    public function handle(int $todoId, int $itemId): Response
    {
        /** @var User $user */
        $user = auth()->user();
        if (is_null($user)) {
            abort(SymfonyResponse::HTTP_UNAUTHORIZED, Response::$statusTexts[SymfonyResponse::HTTP_UNAUTHORIZED]);
        }
        $item = TodoItem::query()
            ->whereTodoId($todoId)
            ->whereId($itemId)
            ->firstOrFail();
        if (!$item->delete()) {
            abort(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR, "Delete Todo Item Fail");
        }
        return response(status: SymfonyResponse::HTTP_NO_CONTENT);
    }
}
