<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Traits\HttpAPI;

class ReceiveController extends Controller
{
    use HttpAPI;
    public function index()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/receiving-order');
        $responseBody = json_decode($response->getBody(), true);
        $receiving = $responseBody['data'];
        $receiving_order = $this->paginate($receiving)->withQueryString();
        $view = "Stock/Receiving/Index";
        return Inertia::render($view, [
            'receiving_order' => $receiving_order
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id',label:"#N0")
              ->column(key: 'created_at',label:"Date Created")
            //   ->column(key: 'from_order',label:"From")
              ->column(key: 'from_code',label:"From code")
              ->column(key: 'items_count',label:"Items")
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
    public function poReceiving($id)
    {
        $response = $this->HTTP_GET_PARAM_STOCK('/api/v1/purchase-order/',$id);
        $responseBody = json_decode($response->getBody(), true);
        $data=$responseBody['data'];
        $purchase_order =null;
        $purchase_order_item=null;
        if(!empty($data)){
            $purchase_order = $data['purchase_order'];
            $purchase_order_item = $data['purchase_order_item'];
        }
        $suppliers = $this->getSupplier();
        $view = "Stock/Receiving/PurchaseReceive";
        return Inertia::render($view,['suppliers'=>$suppliers,'purchase_order'=>$purchase_order,'purchase_order_item'=>$purchase_order_item]);
    }
    public function store(Request $request)
    {
        $response = $this->HTTP_POST_STOCK('/api/v1/receiving-order',$request->all());
        $responseBody = json_decode($response->getBody(), true);
        if($responseBody['code']==200){
            return redirect()->route('receive.index');
        }else{
            return redirect()->back();
        }
    }

    public function boReceiving($id)
    {
        $response = $this->HTTP_GET_PARAM_STOCK('/api/v1/back-order/',$id);
        $responseBody = json_decode($response->getBody(), true);
        $data=$responseBody['data'];
        $back_order =null;
        $back_order_item=null;
        if(!empty($data)){
            $back_order = $data['back_order'];
            $back_order_item = $data['back_order_item'];
        }
        $suppliers = $this->getSupplier();
        $view = "Stock/Receiving/BackReceive";
        return Inertia::render($view,['suppliers'=>$suppliers,'back_order'=>$back_order,'back_order_item'=>$back_order_item]);
    }
}
