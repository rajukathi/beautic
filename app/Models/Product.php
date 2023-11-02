<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tags;

class Product extends Model
{
    protected $table = "product";
    protected $guarded = [];
    protected $appends = ['categories','tags'];

    public function getCategoriesAttribute($value) {
        return Category::whereIn('id', $this->getAttr($this->category_id))->pluck('name')->implode(",");
    }

    public function setCategoryIdAttribute($value) {
        $this->attributes['category_id'] = $this->setAttr( $value );
    }

    public function getTagsAttribute($value) {
        return Tags::whereIn('id', $this->getAttr($this->tag_id))->pluck('name')->implode(",");
    }

    public function setTagIdAttribute($value) {
        $this->attributes['tag_id'] = $this->setAttr( $value );
    }

    public function categories() {
        return $this->hasMany(Category::class);        
    }

    public function tags() {
        return $this->hasMany(Tags::class);        
    }

    public function setAttr($value) {

        if ( !is_array($value) ) {
            $value = (array)$value;
        }

        $value = array_unique($value);

        return implode(",", $value);
    }

    public function getAttr($value) {

        return explode(",", $value);
    }
}
