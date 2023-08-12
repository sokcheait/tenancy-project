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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable();
            $table->string('po_code')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
};
