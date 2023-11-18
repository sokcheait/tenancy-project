<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiSuccessResponse implements Responsable
{
    /**
     * @param  mixed  $data
     * @param  String $message
     * @param  int  $code
     * @param  array  $headers
     */
    public function __construct(
        private mixed $data,
        private String $message,
        private int $code = Response::HTTP_OK,
        private array $headers = []
    ) {}

    /**
     * @param  $request
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'status'  => $this->code,
                'message' => $this->message,
                'data'    => $this->data,
            ],
            $this->code,
            $this->headers
        );
    }
}