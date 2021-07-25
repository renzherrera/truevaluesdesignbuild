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
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('contact');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->foreignId('position_id')->constrained();
            $table->foreignId('schedule_id')->constrained();
            $table->unsignedBigInteger('project_id')->index()->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('SET NULL');
            $table->text('address');
            $table->string('status');
            $table->string('image')->nullable();
            $table->unsignedInteger('biometric_id')->nullable();
            $table->string('card_number')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
