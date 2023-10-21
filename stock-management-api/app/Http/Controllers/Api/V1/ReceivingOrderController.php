<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Actions\ReceivingOrder\CreateReceivingOrder;
use App\Actions\ReceivingOrder\UpdateReceivingOrder;
use App\Models\ReceivingOrder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\BackOrder;
use App\Models\BackOrderItem;

class ReceivingOrderController extends Controller
{
    public function index()
    {
        $receiving_order = DB::table('receiving_orders')
            ->join('purchase_orders','purchase_orders.id','=','receiving_orders.form_id')
            ->join('purchase_order_items','purchase_order_items.po_id','=','receiving_orders.form_id')
            ->whereNull('purchase_order_items.deleted_at')
            ->select('receiving_orders.*','purchase_orders.po_code',
                DB::raw("count(purchase_order_items.po_id) as items_count")
            )
            ->groupBy('receiving_orders.id','purchase_orders.id')
            ->get();
        return response()->json([
                'success'   => true,
                'code'      => 200,
                'message'   => 'Success',
                'data'      => $receiving_order
            ]);
    }
    public function store(Request $request, CreateReceivingOrder $creater)
    {
        if($request->type=="po"){
            $from_order = PurchaseOrder::class;
            $receiving_order = $this->receivePurchase($request,$creater,$from_order);
        }else if($request->type=="bo"){
            $from_order = BackOrder::class;
            $receiving_order = $this->receiveBack($request,$creater,$from_order);
        }
        return response()->json([
                'success'   => true,
                'code'      => 200,
                'message'   => 'Success',
                'data'      => $receiving_order
        ]);
    }
    public function show($id)
    {
        $receiving_order = ReceivingOrder::find($id);
        if(!empty($receiving_order)){
            return response()->json([
                'success'   => true,
                'code'      => 200,
                'message'   => 'Success',
                'data'      => $receiving_order
            ]);
        }else{
            return response()->json([
                'success' => false,
                'code'    => 404,
                'message' => 'Not found',
                'data'    => []
            ]); 
        }
    }
    public function update($id, Request $request, UpdateReceivingOrder $updater)
    {
        $receiving_order = ReceivingOrder::find($id);
        if(!empty($receiving_order)){
            $updater->update($receiving_order,$request->all());
            return response()->json([
                'success'   => true,
                'code'      => 200,
                'message'   => 'Success',
                'data'      => $receiving_order
            ]);
        }else{
            return response()->json([
                'success' => false,
                'code'    => 404,
                'message' => 'Not found',
                'data'    => []
            ]); 
        }
    }
    public function destroy($id)
    {
        $receiving_order = ReceivingOrder::find($id);
        if(!empty($receiving_order)){
            $receiving_order->delete();
            return response()->json([
                'success'   => true,
                'code'      => 200,
                'message'   => 'Success',
                'data'      => $receiving_order
            ]);
        }else{
            return response()->json([
                'success' => false,
                'code'    => 404,
                'message' => 'Not found',
                'data'    => []
            ]); 
        }
    }

    public function receivePurchase($request,$creater,$from_order)
    {
        $input = [
            'form_id'       => optional($request)->po_id,
            'from_order'    =>!empty($from_order)?$from_order:null,
            'amount'        => optional($request)->amount,
            'discount_perc' => optional($request)->discount_perc,
            'discount'      => optional($request)->discount,
            'tax_perc'      => optional($request)->tax_perc,
            'tax'           => optional($request)->tax,
            'stock_ids'     => optional($request)->stock_ids,
            'remarks'       =>null,
            'from_code'     => optional($request)->po_code
        ];
        $po = app(PurchaseOrder::class)->find($request->po_id);
        $receiving_order=[];
        if($po->status == 'pending'){
           $receiving_order= $creater->create($input);
           $bo_code = app(BackOrder::class)->max('id')+1;
            $data_bo = [
                    'receiving_id'=>$receiving_order->id??null,
                    'po_id'=>$request->po_id,
                    'supplier_id'=>$request->supplier_id,
                    'bo_code'=>'BO-00'.$bo_code,
                    'amount'=>optional($request)->amount,
                    'discount_perc'=>optional($request)->discount_perc,
                    'discount'=>optional($request)->discount,
                    'tax_perc'=>optional($request)->tax_perc,
                    'tax'=>optional($request)->tax,
                    'remarks'=>null,
                    'status'=> 'pending',
                ];

            $back_order = $this->storeBackOrder($data_bo); 
        }
        $po->update(['status' => 'partially_received']);
        $input_purchase_order_item = $request->data;
           
        foreach($input_purchase_order_item as $po_item){
            $purchase_order_item = app(PurchaseOrderItem::class)->where('id',$po_item['id'])->first();
            $bo_item_qty = ($purchase_order_item->quantity - $po_item['quantity']);
            $bo_item_price = $po_item['price'];
            $bo_item_unit = $po_item['unit']??null;
            $bo_item_total = (float)$purchase_order_item->total - (float)$po_item['total'];
            if(!empty($back_order->id)){
                $data_bo_item = [
                    'bo_id'=>$back_order->id,
                    'item_id'=>$po_item['item_id'],
                    'quantity'=>$bo_item_qty,
                    'price'=>$bo_item_price,
                    'unit'=>$bo_item_unit,
                    'total'=>$bo_item_total
                ];
                $this->storeBackOrderItem($data_bo_item);
            }
            app(PurchaseOrderItem::class)->where('id',$po_item['id'])->update([
                'quantity'  =>$po_item['quantity']??null,
                'price'     =>$po_item['price']??null,
                'unit'      =>$po_item['unit']??null,
                'total'     =>$po_item['total']??null,
            ]);
        }
        return $receiving_order;
    }

    public function storeBackOrder($request)
    {
        $back_order = BackOrder::create($request);
        return $back_order;
    }

    public function storeBackOrderItem($request)
    {
        $back_order_item = BackOrderItem::create($request);
        return $back_order_item;
    }

    public function receiveBack($request,$creater,$from_order)
    {
        $input = [
            'form_id'       => optional($request)->bo_id,
            'from_order'    =>!empty($from_order)?$from_order:null,
            'amount'        => optional($request)->amount,
            'discount_perc' => optional($request)->discount_perc,
            'discount'      => optional($request)->discount,
            'tax_perc'      => optional($request)->tax_perc,
            'tax'           => optional($request)->tax,
            'stock_ids'     => optional($request)->stock_ids,
            'remarks'       =>null,
            'from_code'     => optional($request)->bo_code
        ];
        $bo = app(BackOrder::class)->find($request->bo_id);
        $po = app(PurchaseOrder::class)->find($bo->po_id);
        $receiving_order=[];
        if($bo->status == 'pending'){
           $receiving_order= $creater->create($input); 
        }
        $bo->update(['status' => 'received']);
        $po->update(['status' => 'received']);
        $input_back_order_item = $request->data;

        foreach($input_back_order_item as $bo_item){
            app(BackOrderItem::class)->where('id',$bo_item['id'])->update([
                'quantity'  =>$bo_item['quantity']??null,
                'price'     =>$bo_item['price']??null,
                'unit'      =>$bo_item['unit']??null,
                'total'     =>$bo_item['total']??null,
            ]);
        }

        return $receiving_order;
    }
}
