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
        Schema::create('back_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receiving_id')->nullable();
            $table->foreignId('po_id')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->string('bo_code')->nullable();
            $table->float('amount')->nullable();
            $table->float('discount_perc')->nullable();
            $table->float('discount')->nullable();
            $table->float('tax_perc')->nullable();
            $table->float('tax')->nullable();
            $table->float('remarks')->nullable();
            $table->boolean('status')->default('false')->index();
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
        Schema::dropIfExists('back_orders');
    }
};
