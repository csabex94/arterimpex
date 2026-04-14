<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model');
            $table->enum('type', ['normal', 'multifunctional', 'label'])->default('normal');
            $table->string('serial_number')->nullable();
            $table->string('ip_address')->nullable();
            $table->longText('photo_url')->nullable();
            $table->foreignId('department_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
