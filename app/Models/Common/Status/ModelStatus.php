<?php

namespace App\Models\Common\Status;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ModelStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'status_id',
        'status_value',
    ];

    public $timestamps = false;

    protected $with = [
        'status',
    ];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
