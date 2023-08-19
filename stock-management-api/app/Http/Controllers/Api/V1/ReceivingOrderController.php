<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\ReceivingOrder\CreateReceivingOrder;
use App\Actions\ReceivingOrder\UpdateReceivingOrder;
use App\Models\ReceivingOrder;

class ReceivingOrderController extends Controller
{
    public function index()
    {
        $receiving_order = ReceivingOrder::all();
        return response()->json([
                'success'   => true,
                'code'      => 200,
                'message'   => 'Success',
                'data'      => $receiving_order
            ]);
    }
    public function store(Request $request, CreateReceivingOrder $creater)
    {
        $receiving_order= $creater->create($request->all());
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
