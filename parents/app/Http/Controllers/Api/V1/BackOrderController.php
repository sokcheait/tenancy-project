<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Traits\HttpAPI;

class BackOrderController extends Controller
{
    use HttpAPI;

    public function index()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/back-order');
        $responseBody = json_decode($response->getBody(), true);
        $bo = $responseBody['data'];
        $back_order = $this->paginate($bo)->withQueryString();
        $view = "Stock/BackOrder/Index";
        return Inertia::render($view, [
            'back_order' => $back_order
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id',label:"#N0")
              ->column(key: 'back_orders')
              ->column(key: 'supplier_id',label:"suppliers")
              ->column(key: 'items')
              ->column(key: 'status',label:"Status")
              ->column(label: 'Actions');
        });
    }
}
