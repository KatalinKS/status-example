<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusController\SetStatusRequest;
use App\Http\Requests\StatusController\UnsetStatusRequest;
use App\Models\Dictionary\ModelName;
use App\Source\Statuses\Contracts\Statusable;
use Illuminate\Support\Facades\Auth;
use Psy\Exception\TypeErrorException;

class StatusController extends Controller
{
    /*
     * Контроллер намеренно выполнен толстым, подлежит рефакторингу (вынос в фасад\в экшены)
     */

    public function setStatus(SetStatusRequest $request, ModelName $modelName, int $modelId): \Illuminate\Http\JsonResponse
    {

        $modelLink = $modelName->getOriginal('link');
        $modelSlug = $modelName->getOriginal('slug');

        if (!Auth::user()->can($modelSlug . '.update')) {
            abort(403);
        }

        $hasStatus = $modelLink::find($modelId);

        if ($hasStatus instanceof Statusable) {
            $hasStatus->setStatus(statusSlug: $request->get('status'), schedule: $request->get('schedule'));
        } else
        {
            throw new TypeErrorException('Ожидается обьект типа '. Statusable::class);
        }

        return response()->json(['message' => 'Статус подключен']);
    }

    public function unsetStatus(UnsetStatusRequest $request, ModelName $modelName, int $modelId): \Illuminate\Http\JsonResponse
    {
        $modelLink = $modelName->getOriginal('link');
        $modelSlug = $modelName->getOriginal('slug');

        if (!Auth::user()->can($modelSlug . '.update')) {
            abort(403);
        }

        $hasStatus = $modelLink::find($modelId);

        if ($hasStatus instanceof Statusable) {
            $hasStatus->detachStatus(status: $request->get('status'));
        } else
        {
            throw new TypeErrorException('Ожидается обьект типа '. Statusable::class);
        }

        return response()->json(['message' => 'Статус отключен']);
    }
}
