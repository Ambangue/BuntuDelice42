<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('driver_id');
            $table->bigInteger('total_items');
            $table->double('offer_discount',6,2);
            $table->double('tax',6,2);
            $table->double('delivery_charges',6,2);
            $table->double('sub_total',6,2);
            $table->double('total',6,2);
            $table->double('admin_commission',6,2);
            $table->double('restaurant_commission',6,2);
            $table->double('driver_tip',6,2);
            $table->enum('status', ['pending','assign', 'completed','cancelled','scheduled'])->default('pending');
            $table->string('delivery_address');
            $table->dateTime('scheduled_date')->nullable();
            $table->string('d_lat');
            $table->string('d_lng');
            $table->dateTime('ordered_time');
            $table->dateTime('delivered_time');
            $table->timestamps();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
