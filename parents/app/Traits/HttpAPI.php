<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Adds a trait for managing multitanancy check on the models
 */
trait HttpAPI
{

    public function HTTP_POST_STOCK($url,$param)
    {
        $header = [
            'Content-Type' => 'application/json',
            'Accept' => "application/json",
            'Authorization' => env("Authorization_Stock")
        ];
        $routes = env("HTTP_STOCK").$url;
        $response = Http::withHeaders($header)->asForm()->post($routes,$param);
        return $response;
    }

    public function HTTP_GET_STOCK($url){
        $header = [
            'Content-Type' => 'application/json',
            'Accept' => "application/json",
            'Authorization' => env("Authorization_Stock")
        ];
        $routes = env("HTTP_STOCK").$url;
        $response = Http::withHeaders($header)->asForm()->get($routes);
        return $response;
    }
    public function HTTP_GET_PARAM_STOCK($url,$param){
        $header = [
            'Content-Type' => 'application/json',
            'Accept' => "application/json",
            'Authorization' => env("Authorization_Stock")
        ];
        $routes = env("HTTP_STOCK").$url.$param;
        $response = Http::withHeaders($header)->asForm()->get($routes);
        return $response;
    }

    public function HTTP_PUT_STOCK($url,$param){
        $header = [
            'Content-Type' => 'application/json',
            'Accept' => "application/json",
            'Authorization' => env("Authorization_Stock")
        ];
        $routes = env("HTTP_STOCK").$url;
        $response = Http::withHeaders($header)->asForm()->put($routes,$param);
        return $response;
    }

    public function HTTP_DELETE_STOCK($url){
        $header = [
            'Content-Type' => 'application/json',
            'Accept' => "application/json",
            'Authorization' => env("Authorization_Stock")
        ];
        $routes = env("HTTP_STOCK").$url;
        $response = Http::withHeaders($header)->asForm()->delete($routes);
        return $response;
    }

    public function paginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total,$perPage);
    }
}