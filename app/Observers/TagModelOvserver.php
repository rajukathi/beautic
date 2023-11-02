<?php

namespace App\Observers;

use App\Models\Tags;
use App\Models\Product;

class TagModelOvserver
{
    public function deleting(Tags $model)
    {
        $query = \DB::table('product')
            ->whereRaw('FIND_IN_SET('.$model->id.', tag_id)')
            ->get();

        foreach ( $query as $key => $value ) {

            $newValue = explode(",", $value->category_id);
            unset($newValue[array_search ($model->id, $newValue)]);
            Product::where('id', $value->id)->update([
                'tag_id' => !empty($newValue) ? implode(",", $newValue) : null
            ]);    
        }
    }
}
