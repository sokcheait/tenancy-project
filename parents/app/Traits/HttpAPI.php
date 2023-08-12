<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

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
}