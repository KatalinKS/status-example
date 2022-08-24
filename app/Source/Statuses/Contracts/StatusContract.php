<?php

namespace App\Source\Statuses\Contracts;

use App\Models\Common\Status\Status;
use Illuminate\Database\Eloquent\Collection;

interface StatusContract
{
    public function statuses();

    public function setStatus(string $statusSlug, string|bool|int|null $statusValue = null, \Illuminate\Support\Collection|array|null $schedule);

    public static function getByStatus(string $slug): Collection;

    public function attachStatus(Status $status): self;

    public function detachStatus(Status $status): self;
}
