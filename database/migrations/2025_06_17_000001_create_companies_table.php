<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('siren')->unique();
            $table->string('name');
            $table->string('sector')->nullable();
            $table->string('size')->nullable(); // PME, ETI, Grande entreprise
            $table->string('country')->default('France');
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->json('contact_info')->nullable();
            $table->timestamps();

            $table->index(['sector', 'size']);
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
