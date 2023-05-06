<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use ProtoneMedia\LaravelMinioTestingTools\UsesMinIOServer;

class Media extends Model
{
    use HasFactory;
    // use UsesMinIOServer;

    protected $fillable = [
        'mediable_id',
        'mediable_type',
        'path'
    ];

    // public static function setPathAttribute()
    // {
    //     $this->bootUsesMinIOServer();
    // }

    // protected function setUp(): void
    // {
    //     parent::setUp();

    //     $this->bootUsesMinIOServer();
    // }
}
