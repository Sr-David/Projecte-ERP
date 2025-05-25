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
        Schema::create('Notes', function (Blueprint $table) {
            $table->id('idNote');
            $table->string('Title', 100)->nullable(false);
            $table->text('Content')->nullable();
            $table->enum('RelatedTo', ['client', 'lead', 'project', 'sale', 'general'])->default('general');
            $table->integer('RelatedID')->nullable();
            $table->integer('CreatedBy')->nullable();
            $table->integer('idEmpresa');
            $table->timestamps();
            
            $table->foreign('idEmpresa')->references('idEmpresa')->on('UserAdministration');
            $table->foreign('CreatedBy')->references('idUser')->on('Users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Notes');
    }
}; 