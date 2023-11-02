<?php

namespace App\Observers;

use App\Models\Category;

class CategoryModelOvserver
{
    public function deleting(Category $model)
    {
        $query = \DB::table('product')
            ->whereRaw('FIND_IN_SET('.$model->id.', category_id)')
            ->get();

        foreach ( $query as $key => $value ) {

            $newValue = explode(",", $value->category_id);
            unset($newValue[array_search ($model->id, $newValue)]);
            
            if ( !empty($newValue) ) {

                Product::where('id', $value->id)->update([
                    'category_id' => implode(",", $newValue)
                ]);    
            } else {

                Product::where('id', $value->id)->delete();  
            }
        }
    }
}
