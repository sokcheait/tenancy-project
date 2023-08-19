<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Traits\HttpAPI;

class PurchaseOrderController extends Controller
{
    use HttpAPI;
    public function index()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/purchase-order');
        $responseBody = json_decode($response->getBody(), true);
        $purchase = $responseBody['data'];
        $purchase_order = $this->paginate($purchase)->withQueryString();
        $view = "Stock/PurchaseOrder/Index";
        return Inertia::render($view, [
            'purchase_order' => $purchase_order
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id')
              ->column(key: 'purchase_orders')
              ->column(key: 'items.suppliers',label:"suppliers")
              ->column(key: 'items')
              ->column(key: 'status',sortable: true)
              ->column(label: 'Actions');
        });
    }
    public function create()
    {
        $view = "Stock/PurchaseOrder/Create";
        return Inertia::render($view);
    }
}
