<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Python Version
    |--------------------------------------------------------------------------
    |
    | The Python interpreter and the extensive standard library are 
    | freely available in source or binary form for all major platforms from the Python web site
    | 
    |
    */

    'python_version' => env('PYTHON_VERSION','python3'),


    /*
    |--------------------------------------------------------------------------
    | face_encoding
    |--------------------------------------------------------------------------
    |
    |  
    | 
    | 
    |
    */

    'face_enc' => base_path().'/app/PythonScript/face_enc.py',

];    