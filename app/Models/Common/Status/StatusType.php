<?php

namespace App\Models\Common\Status;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class StatusType extends Model
{
    use HasFactory, HasTranslations;

    public $fillable = [
        'slug',
        'name',
        'enabled',
    ];

    public array $translatable = [
        'name',
    ];

    public $timestamps = false;

    public static function getBySlug(string $slug): self
    {
        return StatusType::where('slug', '=', $slug)->first();
    }

    public function getId(): int
    {
        return $this->getOriginal('id');
    }


}
