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
        $view = "Stock/BackOrder/Index";
        return Inertia::render($view);
    }
}
