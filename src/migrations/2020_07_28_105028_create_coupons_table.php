<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code_name')->unique();
            $table->enum('type', ['percent','fixprice','freesend']);
            $table->integer('value_discount')->nullable();
            $table->enum('requirements', ['none','monto','quantity']);
            $table->string('req_qty')->nullable();
            $table->integer('limit_number')->nullable();
            $table->boolean('limit_user')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('times_used')->default(0);
            $table->float('discount')->default(0);
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->unsignedBigInteger('couponable_id')->nullable();
            $table->string('couponable_type')->nullable();
            $table->string('min_type')->nullable();
            $table->integer('min_value')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
