<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CategoryModelOvserver;

class Category extends Model
{
    protected $table = "category";
    protected $guarded = [];
    protected $appends = ['parent_category'];
    protected $dispatchesEvents = [
        'deleting' => CategoryModelOvserver::class,
    ];
    
    public function getParentCategoryAttribute() {

        return $this->where('id', $this->parent_id)->first()->name ?? "";
    }
}
