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
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('company_size', ['micro', 'small', 'medium', 'large']);
            $table->string('sector');
            $table->decimal('current_score', 5, 2)->nullable();
            $table->text('improvement_goals');
            $table->enum('budget_range', ['5000-15000', '15000-50000', '50000-100000', '100000+']);
            $table->enum('timeline', ['immediate', '1-3months', '3-6months', '6-12months']);
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'contacted', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_requests');
    }
};
