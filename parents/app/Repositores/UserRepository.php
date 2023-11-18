<?php 

namespace App\Repositores;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository {

    function model(){
       return User::class;
    }
}