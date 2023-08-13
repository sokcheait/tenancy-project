<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Database\QueryException;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Traits\HttpAPI;

class SupplierController extends Controller
{
    use HttpAPI;

    public function index()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/supplier');
        $responseBody = json_decode($response->getBody(), true);
        $supplier = $responseBody['data'];
        $suppliers = $this->paginate($supplier)->withQueryString();
        $view = "Stock/Supplier/Index";
        return Inertia::render($view, [
            'suppliers' => $suppliers
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id')
              ->column(key: 'name', searchable: true, sortable: true, canBeHidden: false)
              ->column(key: 'cperson',sortable: true)
              ->column(key: 'contact',sortable: true)
              ->column(key: 'status',sortable: true)
              ->column(label: 'Actions');
        });
    }

    public function create()
    {
        $view = "Stock/Supplier/Create";
        return Inertia::render($view);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'cperson'  => 'required|max:120',
            'contact'     => 'required',
        ]);
        $response = $this->HTTP_POST_STOCK('/api/v1/supplier',$request->all());
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['code']==200){
            return redirect()->route('supplier.index');
        }else{
            return redirect()->back();
        }
    }

    public function edit($id){
        $response = $this->HTTP_GET_PARAM_STOCK('/api/v1/supplier/',$id);
        $responseBody = json_decode($response->getBody(), true);
        $supplier=$responseBody['data'];
        $view = "Stock/Supplier/Edit";
        return Inertia::render($view,[
            'supplier' => $supplier
         ]);
    }

    public function update($id,Request $request)
    {
        $response = $this->HTTP_PUT_STOCK('/api/v1/supplier/'.$id, $request->all());
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['code']==200){
            return redirect()->route('supplier.index');
        }else{
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $response = $this->HTTP_DELETE_STOCK('/api/v1/supplier/'.$id);
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['code']==200){
            return redirect()->route('supplier.index');
        }else{
            return redirect()->back();
        }
    }
}
