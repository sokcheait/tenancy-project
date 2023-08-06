<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Database\QueryException;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Traits\HttpAPI;

class CategoriesController extends Controller
{
    use HttpAPI;
    public function __construct()
    {
         $this->middleware('permission:categories.index|categories.create|categories.edit|categories.destroy', ['only' => ['index','store']]);
         $this->middleware('permission:categories.create', ['only' => ['create','store']]);
         $this->middleware('permission:categories.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:categories.destroy', ['only' => ['destroy']]);
    }

    public function paginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total   ,$perPage);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/categories');
        $responseBody = json_decode($response->getBody(), true);
        $cate = $responseBody['data'];
        $categories = $this->paginate($cate['categories']);    
        $view = "Stock/Category/Index";
        return Inertia::render($view, [
            'categories' => $categories
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('category_name')
              ->column(key: 'id')
              ->column(key: 'category_name', searchable: true, sortable: true, canBeHidden: false)
              ->column(key: 'is_active',sortable: true)
              ->column(label: 'Actions');
        });
    }

    public function create()
    {
        $view = "Stock/Category/Create";
        return Inertia::render($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:120',
        ]);
        $response = $this->HTTP_POST_STOCK("/api/v1/categories",$request->all());
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['status']==200){
            return redirect()->route('categories.index')->with(['success'=>$responseBody]);
        }else{
            return redirect()->back()->with(['error'=>$responseBody]);
        }
    }


    public function edit($id)
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/categories/'.$id);
        $responseBody = json_decode($response->getBody(), true);
        $categories = $responseBody['data'];
        $view = "Stock/Category/Edit";
        return Inertia::render($view, [
            'categories' => $categories['categories']
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
    public function update(Request $request, $id)
    {
        $body = $request->all();
        $response = $this->HTTP_PUT_STOCK("/api/v1/categories/".$id,$body);
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['status']==200){
            return redirect()->route('categories.index');
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
        $response = $this->HTTP_DELETE_STOCK("/api/v1/categories/".$id);
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['status']==200){
            return redirect()->route('categories.index');
        }
    }
}
