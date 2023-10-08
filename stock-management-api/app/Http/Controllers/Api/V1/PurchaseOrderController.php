<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Actions\PurchaseOrder\CreatePurchaseOrder;
use App\Actions\PurchaseOrder\UpdatePurchaseOrder;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchase_order = DB::table('purchase_orders')
            ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->join('purchase_order_items','purchase_order_items.po_id','=','purchase_orders.id')
            ->whereNull('purchase_order_items.deleted_at')
            ->whereNull('purchase_orders.deleted_at')
            ->select('purchase_orders.*', 'suppliers.name as supplier_name',
                DB::raw("count(purchase_order_items.po_id) as items_count")
            )
            ->groupBy('purchase_orders.id','suppliers.name')
            ->get();
        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $purchase_order
        ]);
    }

    public function store(CreatePurchaseOrder $createrPurchaseOrder,Request $request)
    {
        $input_purchase_order = [
            'supplier_id'   =>$request->supplier_id,
            'po_code'       =>$request->po_code,
            'amount'        =>$request->amount,
            'discount_perc' =>$request->discount_perc,
            'discount'      =>$request->discount,
            'tax_perc'      =>$request->tax_perc,
            'tax'           =>$request->tax,
            'remarks'       =>$request->remarks,
            'status'        =>$request->status
        ];
        $input_purchase_order_item = $request->data;
        $po_code = app(PurchaseOrder::class)->max('id')+1;
        $input_purchase_order['po_code'] = "PO-00".$po_code;
        $purchase_order = $createrPurchaseOrder->create($input_purchase_order);
        foreach($input_purchase_order_item as $po_item){
            $purchase_order_item = PurchaseOrderItem::create([
                'po_id'     =>$purchase_order->id,
                'item_id'   =>$po_item['item_id']??null,
                'quantity'  =>$po_item['quantity']??null,
                'price'     =>$po_item['price']??null,
                'unit'      =>$po_item['unit']??null,
                'total'     =>$po_item['total']??null,
            ]);
        }

        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $purchase_order
        ]);
    }

    public function show($id)
    {
        $purchase_order = app(PurchaseOrder::class)->with('suppliers')->find($id);
        $purchase_order_item = DB::table('purchase_order_items')
            ->join('items','items.id','=','purchase_order_items.item_id')
            ->select('purchase_order_items.*', 'items.name as item_value')
            ->where('purchase_order_items.po_id','=',$id)
            ->whereNull('purchase_order_items.deleted_at')
            ->get();
        $array = [
            'purchase_order' =>$purchase_order,
            'purchase_order_item' =>$purchase_order_item,

        ];
        if($purchase_order_item->isNotEmpty() && !empty($purchase_order)){
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'Success',
                'data'      => $array
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

    public function update(UpdatePurchaseOrder $updaterPurchaseOrder, Request $request, $id)
    {
        $input_purchase_order = [
            'supplier_id'   =>$request->supplier_id,
            'po_code'       =>$request->po_code,
            'amount'        =>$request->amount,
            'discount_perc' =>$request->discount_perc,
            'discount'      =>$request->discount,
            'tax_perc'      =>$request->tax_perc,
            'tax'           =>$request->tax,
            'remarks'       =>$request->remarks,
            'status'        =>$request->status
        ];
        $po = app(PurchaseOrder::class)->find($id);
        $purchase_order = $updaterPurchaseOrder->update($po,$input_purchase_order);
        $input_purchase_order_item = $request->dataItem;
        $dataRemove = $request->dataRemove;
        if(!empty($dataRemove)){
            $pos_item_remove = app(PurchaseOrderItem::class)->whereIn('id',$dataRemove)->delete();
        }
        foreach($input_purchase_order_item as $po_item){
            $po_item_id = $po_item['id']??null;
            if(empty($po_item_id)){
                $purchase_order_item = app(PurchaseOrderItem::class)->create([
                    'po_id'     =>$id,
                    'item_id'   =>$po_item['item_id']??null,
                    'quantity'  =>$po_item['quantity']??null,
                    'price'     =>$po_item['price']??null,
                    'unit'      =>$po_item['unit']??null,
                    'total'     =>$po_item['total']??null,
                ]);
            }else if(!empty($po_item_id)){
                $purchase_order_item = app(PurchaseOrderItem::class)->find($po_item_id)->update([
                    'quantity'  =>$po_item['quantity']??null,
                    'price'     =>$po_item['price']??null,
                    'unit'      =>$po_item['unit']??null,
                    'total'     =>$po_item['total']??null,
                ]);
            }else{
                // $purchase_order_item = app(PurchaseOrderItem::class)->where('id','!=',$po_item['id'])->where('po_id',$id)->delete();
            }
        }
        return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'success',
                'data'      => []
        ]);
       
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
