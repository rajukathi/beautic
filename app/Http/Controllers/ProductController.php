<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {

        $skip = (int)request('skip');
        $take = (int)request('take');
        $getParentProduct = request('getParentProduct',"false");
        
        $product = new Product;

        if ( !empty($skip+$take) ) {

           $product = $product->skip($skip)->take($take);
        }

        $product = $product->orderBy(request('order', 'id'),request('sort', 'desc'))->get();

        return json_encode($product);        
    }

    public function save( Request $request ) {

        Product::create($request->all());

        return true;
    }

    public function delete( $id ) {

        Product::where('id', $id)->delete();

        return true;
    }

}
