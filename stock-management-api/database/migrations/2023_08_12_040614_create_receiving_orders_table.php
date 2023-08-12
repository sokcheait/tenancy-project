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
        Schema::create('receiving_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id')->nullable();
            $table->tinyInteger('from_order')->nullable();
            $table->float('amount')->nullable();
            $table->float('discount_perc')->nullable();
            $table->float('discount')->nullable();
            $table->float('tax_perc')->nullable();
            $table->float('tax')->nullable();
            $table->integer('stock_ids')->nullable();
            $table->float('remarks')->nullable();
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
        Schema::dropIfExists('receiving_orders');
    }
};
