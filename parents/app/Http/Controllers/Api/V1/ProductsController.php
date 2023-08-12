<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpAPI;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductsController extends Controller
{
    use HttpAPI;
    // public function __construct()
    // {
    //      $this->middleware('permission:products.index|products.create|products.edit|products.destroy', ['only' => ['index','store']]);
    //      $this->middleware('permission:products.create', ['only' => ['create','store']]);
    //      $this->middleware('permission:products.edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:products.destroy', ['only' => ['destroy']]);
    // }

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
        //
        // $response = $this->HTTP_GET_STOCK('/api/v1/products');
        // $responseBody = json_decode($response->getBody(), true);
        // $cate = $responseBody['data'];
        // $products = $this->paginate($cate['products']);    
        // $view = "Stock/Category/Index";
        // return Inertia::render($view, [
        //     'products' => $products
        // ])->table(function (InertiaTable $table) {
        //     $table
        //       ->withGlobalSearch()
        //       ->defaultSort('category_name')
        //       ->column(key: 'id')
        //       ->column(key: 'category_name', searchable: true, sortable: true, canBeHidden: false)
        //       ->column(key: 'is_active',sortable: true)
        //       ->column(label: 'Actions');
        // });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
