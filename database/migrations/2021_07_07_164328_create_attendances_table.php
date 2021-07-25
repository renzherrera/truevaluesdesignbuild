<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('biometric_id');
            $table->date('attendance_date');
            $table->time('first_onDuty');
            $table->time('first_offDuty')->nullable()->default(null);
            $table->time('second_onDuty')->nullable()->default(null);
            $table->time('second_offDuty')->nullable()->default(null);
            $table->string('attendance_status')->default('unpaid');
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
        Schema::dropIfExists('attendances');
    }
}
