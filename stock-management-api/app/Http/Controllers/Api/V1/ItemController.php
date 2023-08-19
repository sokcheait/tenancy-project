<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Actions\Item\CreateItem;
use App\Actions\Item\UpdateItem;

class ItemController extends Controller
{
    public function index()
    {
        $item=app(Item::class)->with('suppliers')->get();
        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $item
        ]);
    }
    public function store(CreateItem $createItem ,Request $request)
    {
        $item = $createItem->create($request->all());

        return response()->json([
            'success'   => true,
            'code'    => 200,
            'message'   => 'success',
            'data'      => $item
        ]);
    }

    public function show($id)
    {
        $item=Item::find($id);
        if(!empty($item)){
            $result = $item->with('suppliers')->where('id',$id)->first();
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'success',
                'data'      => $result
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'code'    => 404,
                'message'   => 'Not found !',
                'data'      => $item
            ]);
        }
    }

    public function update($id,Request $request,UpdateItem $updaterItem)
    {
        $item=Item::find($id);
        if(!empty($item)){
            $item->with('suppliers')->get();
            $updaterItem->update($item,$request->all());
            return response()->json([
                'success'   => true,
                'code'    => 200,
                'message'   => 'success',
                'data'      => $item
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'code'    => 404,
                'message'   => 'Not found !',
                'data'      => $item
            ]);
        }
    }

    public function destroy($id)
    {
        $item=Item::find($id);

        if(!empty($item)){
            $item->delete();
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
