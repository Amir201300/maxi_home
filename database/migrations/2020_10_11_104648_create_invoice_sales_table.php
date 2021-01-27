<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('total_price')->nullable();
            $table->string('delivery_cost')->nullable();
            $table->string('cortex_cost')->nullable();
            $table->string('product_cost')->nullable();
            $table->string('tax')->nullable();
            $table->tinyInteger('tax_type')->nullable();
            $table->double('discount',10,2)->default(0)->nullable();
            $table->tinyInteger('discount_type')->default(0)->nullable();
            $table->tinyInteger('invoice_type')->default(0)->nullable();
            $table->tinyInteger('invoice_status')->default(0)->nullable();
            $table->double('deposit',10,2)->default(0)->nullable();
            $table->date('delivery_date')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->foreign('sales_id')->references('id')->on('admin')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_sales');
    }
}
