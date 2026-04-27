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
        Schema::table('loans', function (Blueprint $table) {
    $table->decimal('credit_score', 6, 1)->nullable();
    $table->string('risk_level', 10)->nullable();
    $table->json('risk_probabilities')->nullable();
    $table->integer('recommended_amount_ugx')->nullable();
    $table->json('policy_flags')->nullable();
    $table->text('uncertainty_warning')->nullable();
    $table->timestamp('ml_assessed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            //
        });
    }
};
