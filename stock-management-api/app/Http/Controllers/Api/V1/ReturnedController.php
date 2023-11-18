<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Returned;
use App\Models\Stock;
use App\Actions\Returned\CreateReturned;

class ReturnedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $return = app(Returned::class)->with('suppliers')->get();
        return response()->json([
                'success'   => true,
                'code'      => 200,
                'message'   => 'Success',
                'data'      => $return
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReturned $createReturned ,Request $request)
    {
        $data_item = $request->data;
        foreach($data_item as $key => $item){
            $list_stock = app(Stock::class)->where('item_id',$item['item_id'])->first();
            $stock_quantity = (int)$list_stock->quantity - (int)$item['quantity'];
            $list_stock->update(['quantity' => $stock_quantity]);
            $return_code = app(Returned::class)->max('id')+1;
            $prefix = "R00-";
            $data_return = [
                'supplier_id'=>optional($request)->supplier_id,
                'return_code'=>$prefix.$return_code,
                'amount'     =>optional($request)->amount,
                'remarks'    =>optional($request)->remarks,
                'stock_ids'  =>$list_stock->id,
            ];
            $returned = $createReturned->create($data_return);
        }
        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $returned
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
