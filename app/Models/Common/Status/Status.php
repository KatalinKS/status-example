<?php

namespace App\Models\Common\Status;

use App\Models\Common\Status\StatusType;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

class Status extends Model
{
    use HasFactory, HasTranslations;

    public $fillable = [
        'status_id',
        'slug',
        'name',
        'value',
        'enabled',
    ];

    public array $translatable = [
        'name',
        'value',
    ];

    protected $hidden = [
        'pivot'
    ];

    public $timestamps = false;

    protected $with = ['statusType'];

    public function statusType(): BelongsTo
    {
        return $this->belongsTo(StatusType::class);
    }

    public function getId(): int
    {
        return $this->getOriginal('id');
    }

    public static function findBySlug(string $slug)
    {
        return self::where('slug', '=', $slug)->first();
    }

    public function schedule(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StatusTask::class);
    }

    public function addTasks(Collection $tasks)
    {
        $this->schedule()->insert($tasks->toArray());
    }

}
