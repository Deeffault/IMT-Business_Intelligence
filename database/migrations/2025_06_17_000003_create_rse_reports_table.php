<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rse_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('report_type')->default('detailed'); // basic, detailed, custom
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->decimal('price', 8, 2);
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');

            // Contenu du rapport
            $table->json('analysis_criteria')->nullable();
            $table->longText('report_content')->nullable();
            $table->json('recommendations')->nullable();
            $table->json('improvement_areas')->nullable();

            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'payment_status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rse_reports');
    }
};
