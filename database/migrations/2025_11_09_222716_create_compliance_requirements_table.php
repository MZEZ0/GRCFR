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
        Schema::create('compliance_requirements', function (Blueprint $table) {
            $table->id();

            // === Foreign Key to Compliance Framework ===
            // Every requirement belongs to one compliance framework (e.g., ISO 27001, GDPR, NIST)
            $table->foreignId('framework_id')
                  ->constrained('frameworks')
                  ->onDelete('cascade');

            // === Core Requirement Information ===
            $table->string('reference_code')->nullable(); // e.g., A.12.3.1 or Article 32
            $table->string('title');                      // Short requirement name
            $table->text('description')->nullable();      // Detailed explanation of the requirement
            $table->enum('category', [
                'Legal', 'Technical', 'Organizational', 'Operational', 'Privacy', 'Security'
            ])->nullable();                               // Optional grouping

            // === Status / Metadata ===
            $table->enum('status', ['active', 'retired', 'pending'])->default('active');
            $table->integer('priority')->nullable();       // For ordering or risk weighting
            $table->text('guidance')->nullable();          // Implementation guidance or examples

            // === Audit / Timestamps ===
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_requirements');
    }
};
