<?php


namespace App\Source\Statuses\Traits;

use App\Models\Common\Status\ModelStatus;
use App\Models\Common\Status\Status;
use App\Models\Common\Status\StatusTask;
use App\Source\Statuses\Constants\StatusScheduleAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasStatus
{
    public function statusSchedule(): MorphMany
    {
        return $this->morphMany(StatusTask::class, 'model')
            ->where('action', '!=', StatusScheduleAction::COMPLETE);
    }

    public function statuses()
    {
        return $this->morphToMany(Status::class, 'model', 'model_statuses');
    }

    public function setStatus(string $statusSlug, string|bool|int $statusValue = null, \Illuminate\Support\Collection|array|null $schedule = null)
    {
        $status = Status::where('slug', $statusSlug)->first();

        $additionalData = [
            'model_type' => self::class,
            'model_id' => $this->id,
            'status_id' => $status->id,
            'status_value' => $statusValue,
        ];

        if ($this->hasStatus($status)) {
            return $this;
        }

        if (!$schedule) {
            if (!$this->hasStatus($status)) {
                ModelStatus::create($additionalData);
            }
        } else {
            $schedule = is_array($schedule) ? collect($schedule) : $schedule;

            $schedule = $schedule->map(function ($task) use ($additionalData) {
                return StatusTask::fromArray(array_merge($additionalData, $task));
            });

            $status->addTasks($schedule);
        }


        return $this;
    }

    public static function getByStatus(string $slug): Collection
    {
        $status = Status::where('slug', '=', $slug)->first();

        return self::whereRelation(
            'statuses', 'status_id', '=', $status->id
        )->get();
    }

    public function attachStatus(Status $status): self
    {
        if (!$this->hasStatus($status)) {
            $this->statuses()->attach($status);
        }

        return $this;
    }

    public function detachStatus(Status|string $status): self
    {
        $status = is_string($status) ? Status::where('slug', $status)->first() : $status;

        $this->statuses()->detach($status);

        return $this;
    }

    public function hasStatus(Status|string $status): bool
    {
        if (is_string($status)) {
            $status = Status::where('slug', '=', $status)->first();
        }

        return (bool)$this->statuses()
            ->where('status_id', '=', $status->getId())
            ->count();
    }

}
