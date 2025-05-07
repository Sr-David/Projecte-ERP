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
        Schema::create('UserAdministration', function (Blueprint $table) {
            $table->id(); // Clave primaria auto-incremental
            $table->string('Username', 100); // Equivalente a varchar(100)
            $table->string('Password', 255); // Equivalente a varchar(255)
            $table->text('Permissions'); // Campo de texto largo
        });
    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('UserAdministration');
    // }
};