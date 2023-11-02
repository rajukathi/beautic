<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index() {

        $skip = (int)request('skip');
        $take = (int)request('take');
        $tags = new Tags;

        if ( !empty($skip+$take) ) {

           $tags = $tags->skip($skip)->take($take);
        }

        $tags = $tags->orderBy(request('order', 'id'),request('sort', 'desc'))->get();

        return json_encode($tags);        
    }

    public function save( Request $request ) {

        Tags::create($request->all());

        return true;
    }

    public function delete( $id ) {

        Tags::where('id', $id)->delete();

        return true;
    }

}
