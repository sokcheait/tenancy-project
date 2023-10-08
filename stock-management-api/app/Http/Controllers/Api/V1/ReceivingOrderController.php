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
        }
        $input = [
            'form_id'       =>!empty($request->po_id)?$request->po_id:null,
            'from_order'    =>!empty($from_order)?$from_order:null,
            'amount'        =>!empty($request->amount)?$request->amount:null,
            'discount_perc' =>!empty($request->discount_perc)?$request->discount_perc:null,
            'discount'      =>!empty($request->discount)?$request->discount:null,
            'tax_perc'      =>!empty($request->tax_perc)?$request->tax_perc:null,
            'tax'           =>!empty($request->tax)?$request->tax:null,
            'stock_ids'     =>!empty($request->stock_ids)?$request->stock_ids:null,
            'remarks'       =>null,
        ];
        $input_purchase_order_item = $request->data;
        // info($input_purchase_order_item);
        // $purchase_order_item = app(PurchaseOrderItem::class)->find($request->po_id);
        // info($request->po_id);
        foreach($input_purchase_order_item as $po_item){
            $purchase_order_item = app(PurchaseOrderItem::class)->whereIn('id',$po_item->id)->update([
                'quantity'  =>$po_item['quantity']??null,
                'price'     =>$po_item['price']??null,
                'unit'      =>$po_item['unit']??null,
                'total'     =>$po_item['total']??null,
            ]);
        }
        $receiving_order= $creater->create($input);
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
}
