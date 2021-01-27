<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_dailies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount')->default(0)->nullable();
            $table->text('desc')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('modelType')->nullable();
            $table->bigInteger('model_id')->nullable();
            $table->unsignedBigInteger('paymentType_id')->nullable();
            $table->foreign('paymentType_id')->references('id')->on('payment_types')->onDelete('set null');
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
        Schema::dropIfExists('money_dailies');
    }
}
