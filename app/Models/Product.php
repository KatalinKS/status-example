<?php

namespace App\Models;

use App\Source\Statuses\Contracts\StatusContract;
use App\Source\Statuses\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements StatusContract
{
    use HasFactory, HasStatus;

    protected $fillable = [
        'name'
    ];
}
