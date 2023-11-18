<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Traits\HttpAPI;

class StockController extends Controller
{
    use HttpAPI;
    public function index()
    {
        $response = $this->HTTP_GET_STOCK('/api/v1/stock');
        $responseBody = json_decode($response->getBody(), true);
        $stock = $responseBody['data'];
        $stock_list = $this->paginate($stock)->withQueryString();
        $view = "Stock/Index";
        return Inertia::render($view, [
            'stock_list' => $stock_list
        ])->table(function (InertiaTable $table) {
            $table
              ->withGlobalSearch()
              ->defaultSort('name')
              ->column(key: 'id',label:"#N0")
              ->column(key: 'items')
              ->column(key: 'suppliers',label:"suppliers")
              ->column(key: 'quantity',label:"Available Stocks")
              ->column(label: 'Actions');
        });
    }
}
