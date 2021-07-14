<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_summary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payroll_id')->index()->nullable();
            $table->foreign('payroll_id')->references('id')->on('payrolls')->onUpdate('cascade')->onDelete('cascade');
            $table->string('employee_name');
            $table->string('position_title');
            $table->string('project_designated');
            $table->string('schedule');
            $table->decimal('salary_rate',12,2);
            $table->integer('total_hours_regular');
            $table->integer('total_hours_overtime');
            $table->decimal('total_holidaypay',12,2);
            $table->decimal('salary_gross',12,2);
            $table->decimal('cash_advance',12,2);
            $table->decimal('total_net_pay',12,2);

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
        Schema::dropIfExists('payroll_summary');
    }
}
