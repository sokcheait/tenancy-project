<?php

namespace App\Repositores;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Supplier;

class SupplierRepositore extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Supplier::class;
    }
}