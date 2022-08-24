<?php

namespace App\Source\Statuses;

use App\Source\Statuses\Contracts\StatusContract;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class Status
{
    public static function detachStatusFromMany(Collection $items, \App\Models\Common\Status\Status $status): void
    {
        $items->each(function ($item) use ($status) {
            if ($item instanceof StatusContract)
            {
                $item->detachStatus($status);
            } else {
                throw new Exception('Класс не имеет статус');
            }
        });
    }

    public function detachStatus(StatusContract $statusable, String $statusSlug): void
    {
        $status = \App\Models\Common\Status\Status::findBySlug($statusSlug);

        $statusable->detachStatus($status);
    }
}
