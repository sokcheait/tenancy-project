<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackOrderItem;
use App\Models\BackOrder;
use App\Actions\BackOrder\CreateBackOrder;

class BackOrderController extends Controller
{
    public function index()
    {
        dd(123);
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
        
    }
     public function destroy($id)
    {
        
    }
}
