<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackOrderItem;
use App\Models\BackOrder;
use App\Actions\BackOrder\CreateBackOrder;
use Illuminate\Support\Facades\DB;

class BackOrderController extends Controller
{
    public function index()
    {
        $back_order = DB::table('back_orders')
            ->join('suppliers', 'back_orders.supplier_id', '=', 'suppliers.id')
            ->join('back_order_items','back_order_items.bo_id','=','back_orders.id')
            ->whereNull('back_order_items.deleted_at')
            ->whereNull('back_orders.deleted_at')
            ->select('back_orders.*', 'suppliers.name as supplier_name',
                DB::raw("count(back_order_items.bo_id) as items_count")
            )
            ->groupBy('back_orders.id','suppliers.name')
            ->get();
        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $back_order
        ]);
    }
    public function store(Request $request,CreateBackOrder $creater)
    {
        $back_order=$creater->create($request->all());
        return response()->json([
                'success'   => true,
                'code'      => 200,
                'message'   => 'Success',
                'data'      => $back_order
        ]);
    }
    public function show($id)
    {
        $back_order = app(BackOrder::class)->with('suppliers')->find($id);
        $back_order_item = DB::table('back_order_items')
            ->join('items','items.id','=','back_order_items.item_id')
            ->select('back_order_items.*', 'items.name as item_value')
            ->where('back_order_items.bo_id','=',$id)
            ->whereNull('back_order_items.deleted_at')
            ->get();
        $array = [
            'back_order' =>$back_order,
            'back_order_item' =>$back_order_item,

        ];
        if($back_order_item->isNotEmpty() && !empty($back_order)){
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
     public function destroy($id)
    {
        
    }
}
