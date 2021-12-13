<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function tickets(String $id)
    {
       $response = [];

       $category = Category::find($id);

       $tickets = $category->tickets()->paginate();

       $response['status'] = true;
       $response['message'] = 'success';
       $response['data'] = $tickets;

       return response()->json($response, 200);
    }

    public function all()
    {
       $response = [];

       $categories = Category::all();

       $response['status'] = true;
       $response['message'] = 'success';
       $response['data'] = $categories;

       return response()->json($response, 200);
    }
}
