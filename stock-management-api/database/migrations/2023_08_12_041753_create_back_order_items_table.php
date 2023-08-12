<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('back_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bo_id')->nullable();
            $table->foreignId('item_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('price')->nullable();
            $table->string('unit')->nullable();
            $table->float('total')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('back_order_items');
    }
};
