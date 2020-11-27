<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('head_id')->nullable();
            $table->date('employment_date');
            $table->string('phone_number');
            $table->string('email');
            $table->decimal('salary', 6, 3, true);
            $table->string('photo');
            $table->timestamps();
            $table->unsignedBigInteger('admin_created_id');
            $table->unsignedBigInteger('admin_updated_id');

            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('head_id')->references('id')->on('employees');
            $table->foreign('admin_created_id')->references('id')->on('users');
            $table->foreign('admin_updated_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
