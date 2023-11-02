<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {

        $skip = (int)request('skip');
        $take = (int)request('take');
        $getParentCategory = request('getParentCategory',"false");
        
        $category = new Category;

        if ( !empty($skip+$take) ) {

           $category = $category->skip($skip)->take($take);
        }

        $category = $category->orderBy(request('order', 'id'),request('sort', 'desc'))->get();

        /*if ( $getParentCategory == "true" ) {

            $category = $category->pluck('name','id');
        }*/

        return json_encode($category);        
    }

    public function save( Request $request ) {

        Category::create($request->all());

        return true;
    }

    public function delete( $id ) {

        Category::where('id', $id)->delete();

        return true;
    }

}
