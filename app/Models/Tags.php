<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\TagModelOvserver;

class Tags extends Model
{
    protected $table = "tags";
    protected $guarded = [];
    protected $dispatchesEvents = [
        'deleting' => TagModelOvserver::class,
    ];
}
