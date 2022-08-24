<?php

namespace App\Models\Common\Status;

use App\Models\Model;
use App\Source\Statuses\Constants\StatusScheduleAction;
use App\Source\Statuses\Contracts\Statusable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class StatusTask extends Model
{
    protected $table = 'status_schedule';

    protected $fillable = [
        'action',
        'start_at',
        'end_at',
        'status_id',
        'model_type',
        'model_id',
    ];

    protected $with = [
        'statusable',
        'status'
    ];

    public $timestamps = false;

    use HasFactory;

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function completed(): self
    {
        $this->setAttribute('action', StatusScheduleAction::COMPLETE);

        $this->save();

        return $this;
    }

    public function setAction(string $action): self
    {
        $this->setAttribute('action', $action);

        $this->save();

        return $this;
    }



    public function nextAction()
    {
        if ($this->getStatus() == StatusScheduleAction::SET && $this->getOriginal('end_at')) {
            $this->setAction(StatusScheduleAction::UNSET);
        } else {
            $this->completed();
        }

        return $this;
    }


    public static function fromArray(array $array): self
    {
        $action = $array['start_at'] ? StatusScheduleAction::SET : StatusScheduleAction::UNSET;

        return (new self())->fill(
            [
                'id' => $array['id'] ?? null,
                'status_id' => $array['status_id'],
                'action' => $action,
                'start_at' => $array['start_at'],
                'end_at' => $array['end_at'],
                'model_type' => $array['model_type'],
                'model_id' => $array['model_id']
            ]
        );
    }

    public function statusable()
    {
        return $this->morphTo('statusable', 'model_type', 'model_id');
    }

    public function getStatusable(): Statusable
    {
        return $this->getRelationValue('statusable');
    }

    public function getAction(): string
    {
        return $this->getOriginal('action');
    }

    public function getStatus()
    {
        return $this->getRelationValue('status');
    }

    public static function getActive(): Collection
    {
        $now = Carbon::now();

        return self::where(function(Builder $query) use ($now) {
            $query->where('action', '=', StatusScheduleAction::SET)
                ->where('start_at', '<=', $now);
            })
            ->orWhere(function (Builder $query) use ($now) {
                $query->where('action', '=', StatusScheduleAction::UNSET)
                    ->where('end_at', '<=', $now);
            })
            ->get();
    }

}
