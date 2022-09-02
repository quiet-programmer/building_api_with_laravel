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
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->boolean('has_plan')->default(false);
            $table->string('plan_type')->nullable();
            $table->string('days_left')->nullable();
            $table->boolean('has_expired')->default(false);
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->foreignId('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_accounts');
    }
};
