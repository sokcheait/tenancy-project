<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Actions\PurchaseOrder\CreatePurchaseOrder;
use App\Actions\PurchaseOrder\UpdatePurchaseOrder;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchase_order=app(PurchaseOrderItem::class)->with(['purchaseOrders','items','items.suppliers'])->get();

        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $purchase_order
        ]);
    }

    public function store(CreatePurchaseOrder $createrPurchaseOrder,Request $request)
    {
        $purchase_order = $createrPurchaseOrder->create($request->all());

        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $purchase_order
        ]);
    }

    public function show($id)
    {
        $purchase_order = PurchaseOrder::find($id);
        $purchase_order_item = PurchaseOrderItem::with(['purchaseOrders','items','items.suppliers'])->where('po_id',$id)->get();
        if($purchase_order_item->isNotEmpty()){
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'Success',
                'data'      => $purchase_order_item
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'code'    => 404,
                'message'   => 'Not found !',
                'data'      => $purchase_order_item
            ]);
        }
        
    }

    public function update(UpdatePurchaseOrder $updaterPurchaseOrder, Request $request, $id)
    {
        $purchase_order_item = PurchaseOrderItem::with(['purchaseOrders'])->where('po_id',$id)->first();
        if(!empty($purchase_order_item)){
            $updaterPurchaseOrder->update($purchase_order_item,$request->all());
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'success',
                'data'      => $purchase_order_item
            ]);
         }else{
            return response()->json([
                'success'   => false,
                'code'    => 404,
                'message'   => 'Not found !',
                'data'      => $purchase_order_item
            ]);
         }
       
    }

    public function destroy($id)
    {
        $purchase_order_item = PurchaseOrderItem::with(['purchaseOrders'])->where('po_id',$id)->first();
        if(!empty($purchase_order_item)){
            $purchase_order_item->delete();
            $purchase_order_item->purchaseOrders->delete();
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'success',
                'data'      => []
            ]);
         }else{
            return response()->json([
                'success'   => false,
                'code'    => 404,
                'message'   => 'Not found !',
                'data'      => []
            ]);
         }
    }
}
