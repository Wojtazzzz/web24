<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->mediumInteger('id')->unsigned()->primary()->autoIncrement();
            $table->string('name');
            $table->string('nip', 10);
            $table->string('address');
            $table->string('city');
            $table->string('postcode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
