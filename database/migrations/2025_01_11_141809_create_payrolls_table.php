<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pay_period_id')->nullable(false); // Ensure this column exists
            $table->unsignedBigInteger('reservation_id')->nullable(true);
            $table->foreign('pay_period_id')->references('id')->on('pay_periods')->onDelete('cascade');
            $table->decimal('gross_salary', 10, 2);
            $table->decimal('sss_deductions', 10, 2)->default(0);
            $table->decimal('pag_ibig_deductions', 10, 2)->default(0);
            $table->decimal('philhealth_deductions', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
};
