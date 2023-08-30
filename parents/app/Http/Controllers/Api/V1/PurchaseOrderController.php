<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Traits\HttpAPI;

class PurchaseOrderController extends Controller
{
    use HttpAPI;
    public function index()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/purchase-order');
        $responseBody = json_decode($response->getBody(), true);
        $purchase = $responseBody['data'];
        $purchase_order = $this->paginate($purchase)->withQueryString();
        $view = "Stock/PurchaseOrder/Index";
        return Inertia::render($view, [
            'purchase_order' => $purchase_order
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id')
              ->column(key: 'purchase_orders')
              ->column(key: 'items.suppliers',label:"suppliers")
              ->column(key: 'items')
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
    public function getItem($id)
    {
        $response = $this->HTTP_GET_PARAM_STOCK('/api/v1/find-item/',$id);
        $responseBody = json_decode($response->getBody(), true);
        $item = $responseBody['data'];
        $object =[];
        $cost_item=[];
        if(!empty($item)){
            foreach ($item as $key => $value)
            {
                if($value['status']==true)
                    $object[$value['id']] = $value['name'];
                    $cost_item[$value['id']] = $value['cost'];
            }
            $result = ['data'=>$object,'data_all'=>$cost_item];
            return $result;
        }
        // // $view = "Stock/PurchaseOrder/Create";
        // // return Inertia::render($view,['items' => $object]);
        // return $object;
        
    }
    public function create()
    {
        $suppliers = $this->getSupplier();
        $view = "Stock/PurchaseOrder/Create";
        return Inertia::render($view,['suppliers' => $suppliers]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|max:120',
            'item_id'  => 'required|max:120',
        ]);
        dd($request->all());
    }

}
