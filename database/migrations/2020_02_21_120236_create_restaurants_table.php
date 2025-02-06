<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('user_name')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('slogan')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('services');
            $table->double('service_charges')->nullable();
            $table->double('delivery_charges');
            $table->string('city');
            $table->double('tax',8,2);
            $table->string('address');
            $table->float('latitude',10,2)->nullable();
            $table->float('longitude',10,2)->nullable();
            $table->string('phone')->unique();
            $table->string('description')->nullable();
            $table->integer('min_order')->nullable();
            $table->time('avg_delivery_time')->nullable();
            $table->integer('delivery_range')->nullable();
            $table->double('admin_commission');
            $table->boolean('approved')->default(false);
            $table->boolean('featured')->default(false);
            $table->string('account_name');
            $table->string('account_number');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
