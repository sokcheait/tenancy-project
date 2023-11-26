<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Localization
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    //  * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    //  */
    // public function handle(Request $request, Closure $next)
    // {
    //     /** 
    //      * requests hasHeader is used to check the Accept-Language header from the REST API's
    //      */
    //     if ($request->hasHeader("Accept-Language")) {
    //         /**
    //          * If Accept-Language header found then set it to the default locale
    //          */
    //         App::setLocale($request->header("Accept-Language"));
    //     }
    //     return $next($request);
    // }

     /**
     * Localization constructor.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // read the language from the request header
        $locale = $request->header('Accept-Language');

        // if the header is missed
        if(!$locale){
            // take the default local language
            $locale = $this->app->config->get('app.locale');
        }

        // check the languages defined is supported
        // if (!array_key_exists($locale, $this->app->config->get('app.supported_languages'))) {
        //     // respond with error
        //     return abort(403, 'Language not supported.');
        // }

        // set the local language
        $this->app->setLocale($locale);

        // get the response after the request is done
        $response = $next($request);

        // set Content Languages header in the response
        $response->headers->set('Accept-Language', $locale);

        // return the response
        return $response;
    }
}
