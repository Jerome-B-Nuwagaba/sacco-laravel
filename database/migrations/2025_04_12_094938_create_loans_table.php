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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('amount'); 
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('loan_type_id')->constrained('loan_types')->onDelete('cascade'); 
            $table->enum('status', ['pending', 'forwarded', 'rejected', 'approved', 'active', 'paid'])->default('pending'); 
            $table->timestamps();
            $table->foreignId('loan_officer_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
