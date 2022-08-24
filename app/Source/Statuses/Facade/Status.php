<?php

namespace App\Source\Statuses\Facade;

use Illuminate\Support\Facades\Facade;

class Status extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Source\Statuses\Status::class;
    }
}
