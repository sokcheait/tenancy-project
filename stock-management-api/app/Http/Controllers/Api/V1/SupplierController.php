<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Actions\Supplier\CreateSupplier;
use App\Actions\Supplier\UpdateSupplier;

class SupplierController extends Controller
{
    public function index()
    {
       $supplier = Supplier::all();
       return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $supplier
        ]);
    }
    public function store(CreateSupplier $createrSupplier ,Request $request)
    {
        $supplier = $createrSupplier->create($request->all());
        
        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $supplier
        ]);
    }

    public function show($id)
    {
        $supplier=Supplier::find($id);
        if(!empty($supplier)){
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'Success',
                'data'      => $supplier
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'code'    => 404,
                'message'   => 'Not found !',
                'data'      => $supplier
            ]);
        }
    }

    public function update(UpdateSupplier $updaterSupplier, Request $request,$id)
    {
        $supplier=Supplier::find($id);

        if(!empty($supplier)){
            $updaterSupplier->update($supplier,$request->all());
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'Success',
                'data'      => $supplier
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'code'    => 404,
                'message'   => 'Not found !',
                'data'      => $supplier
            ]);
        }
    }

    public function destroy($id)
    {
        $supplier=Supplier::find($id);
        if(!empty($supplier)){
            $supplier->delete();
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'Success',
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
