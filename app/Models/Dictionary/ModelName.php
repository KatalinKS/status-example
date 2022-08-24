<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelName extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',

    ];

    public $timestamps = false;
}
