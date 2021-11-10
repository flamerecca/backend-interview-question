<?php

namespace App\Actions\Todo;

use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Response;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CreateOrUpdateTodo
{
    use AsAction;

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255'
            ],
        ];
    }

    public function handle(ActionRequest $request, ?int $todoId = null)
    {
        /** @var User $user */
        $user = auth()->user();
        if (is_null($user)) {
            abort(SymfonyResponse::HTTP_UNAUTHORIZED, Response::$statusTexts[SymfonyResponse::HTTP_UNAUTHORIZED]);
        }
        if ($todoId) {
            return TodoResource::make(
                tap(
                    Todo::query()->findOrFail($todoId),
                    static fn (Todo $todoItem) => $todoItem->update($request->validated())
                )
            );
        }

        $todoData = array_merge($request->validated(), [
            'user_id' => $user->id,
        ]);

        return TodoResource::make(Todo::query()->create($todoData));
    }
}
