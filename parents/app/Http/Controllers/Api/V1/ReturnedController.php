<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Traits\HttpAPI;

class ReturnedController extends Controller
{
    use HttpAPI;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = "Stock/Returned/Index";
        // return Inertia::render($view);
        $response = $this->HTTP_GET_STOCK('/api/v1/returned');
        $responseBody = json_decode($response->getBody(), true);
        $return = $responseBody['data'];
        $return_list = $this->paginate($return)->withQueryString();
        return Inertia::render($view, [
            'return_list' => $return_list
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id',label:"#N0")
              ->column(key: 'created_at',label:"Date Created")
              ->column(key: 'return_code',label:"Return code")
              ->column(key: 'suppliers',label:"suppliers")
              ->column(key: 'items',label:"items")
              ->column(label: 'Actions');
        });
    }
    public function getSupplier()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/supplier');
        $responseBody = json_decode($response->getBody(), true);
        $supplier = $responseBody['data'];
        $object =[];
        if(!empty($supplier)){
            foreach ($supplier as $key => $value)
            {
                if($value['status']==true)
                    $object[$value['id']] = $value['name'];
            }
            return $object;
        }
    }

    public function create()
    {
        $suppliers = $this->getSupplier();
        $view = "Stock/Returned/Create";
        return Inertia::render($view,['suppliers' => $suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->HTTP_POST_STOCK('/api/v1/returned',$request->all());
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['code']==200){
            return redirect()->route('returned.index');
        }else{
            return redirect()->back();
        }
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
