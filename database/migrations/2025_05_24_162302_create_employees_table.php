<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->mediumInteger('id')->unsigned()->primary()->autoIncrement();
            $table->mediumInteger('company_id')->unsigned()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone', 20)->nullable();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->unique(['company_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
