<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Traits\HttpAPI;

class ItemController extends Controller
{
    use HttpAPI;
    public function index()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/item');
        $responseBody = json_decode($response->getBody(), true);
        $item = $responseBody['data'];
        $items = $this->paginate($item)->withQueryString();
        $view = "Stock/Item/Index";
        return Inertia::render($view, [
            'items' => $items
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id')
              ->column(key: 'suppliers')
              ->column(key: 'name',sortable: true)
              ->column(key: 'cost',sortable: true)
              ->column(key: 'status',sortable: true)
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
        $suppliers= $this->getSupplier();
        $view = "Stock/Item/Create";
        return Inertia::render($view,['suppliers'=>$suppliers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:120',
            'cost'        => 'required',
            'supplier_id' => 'required',
        ]);
        $response = $this->HTTP_POST_STOCK('/api/v1/item',$request->all());
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['code']==200){
            return redirect()->route('item.index');
        }else{
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        $response = $this->HTTP_GET_PARAM_STOCK('/api/v1/item/',$id);
        $responseBody = json_decode($response->getBody(), true);
        $item=$responseBody['data'];
        $suppliers= $this->getSupplier();
        $view = "Stock/Item/Edit";
        return Inertia::render($view,['suppliers'=>$suppliers,'item'=>$item]);
    }
    public function update($id,Request $request)
    {
        $response = $this->HTTP_PUT_STOCK('/api/v1/item/'.$id, $request->all());
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['code']==200){
            return redirect()->route('item.index');
        }else{
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $response = $this->HTTP_DELETE_STOCK('/api/v1/item/'.$id);
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['code']==200){
            return redirect()->route('item.index');
        }else{
            return redirect()->back();
        }
    }
}
