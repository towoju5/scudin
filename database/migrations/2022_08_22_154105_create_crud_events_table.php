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
        Schema::create('crud_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('label');
            $table->string('event_url');
            // $table->string('add_guest');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('start_date')->comment('Order Placement Date');
            $table->date('end_date')->nullable()->comment('Expected Delivery Date');  
            $table->longText('desription')->nullable();          
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('seller_id')->references('id')->on('sellers');
            $table->foreign('customer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crud_events');
    }
};
