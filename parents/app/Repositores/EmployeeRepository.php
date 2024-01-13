<?php 

namespace App\Repositores;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Employee;

class EmployeeRepository extends BaseRepository {

    function model(){
       return Employee::class;
    }
}