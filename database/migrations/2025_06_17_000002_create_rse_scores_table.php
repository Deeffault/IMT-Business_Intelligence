<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rse_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            // Scores par thématiques (0-100)
            $table->decimal('environmental_score', 5, 2)->nullable();
            $table->decimal('social_score', 5, 2)->nullable();
            $table->decimal('governance_score', 5, 2)->nullable();
            $table->decimal('ethics_score', 5, 2)->nullable();

            // Score global calculé
            $table->decimal('global_score', 5, 2);
            $table->string('rating_letter')->nullable(); // A+, A, B, C, D

            // Métadonnées
            $table->json('detailed_metrics')->nullable(); // CO2, déchets, égalité, etc.
            $table->json('data_sources')->nullable(); // APIs utilisées
            $table->date('last_updated');
            $table->integer('data_quality_score')->default(0); // 0-100

            $table->timestamps();

            $table->index(['global_score', 'last_updated']);
            $table->index('rating_letter');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rse_scores');
    }
};
