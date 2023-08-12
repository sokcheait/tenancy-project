<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesStoreRequest;
use App\Http\Requests\CategoriesUpdateRequest;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = app(Category::class)->all();
        return response()->json([
            'status'=> 200,
            'message'=> "success",
            'data' => [
                'categories' => $category
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesStoreRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json([
            'status' => 200,
            'message' => "success",
            'data' => [
                'categories'=>$category
            ]
        ]);
    }

    public function edit($id)
    {
        $category = app(Category::class)->find($id);
        return response()->json([
            'status'=> 200,
            'message'=> "success",
            'data' => [
                'categories' => $category
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesUpdateRequest $request, $id)
    {
        $categories = app(Category::class)->find($id);
        if(!empty($categories)){
            $categories->update($request->validated());
                return response()->json([
                    'success'=> true,
                    'status'=> 200,
                    'message'=> "success",
                    'data' => [
                        'categories' => $categories
                    ]
                ]);
        }else{
            return response()->json([
                'success'=> false,
                'status'=> 404,
                'message'=> "not found",
                'data' => []
            ]);
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = app(Category::class)->find($id);
        if(!empty($categories)){
            $categories->delete();
            return response()->json([
                'success'=> true,
                'status'=> 200,
                'message'=> "success",
                'data' => []
            ]);
        }else{
            return response()->json([
                'success'=> false,
                'status'=> 404,
                'message'=> "not found",
                'data' => []
            ]);
        }
        
    }
}
