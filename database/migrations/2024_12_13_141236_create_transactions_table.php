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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction_id');
            $table->string('type');
            $table->nullableMorphs('by');
            $table->nullableMorphs('from');
            $table->nullableMorphs('to');
            $table->decimal('amount', 13)->unsigned();
            $table->decimal('to_balance_before', 13)->unsigned()->nullable();
            $table->decimal('to_balance_after', 13)->unsigned()->nullable();
            $table->decimal('from_balance_before', 13)->unsigned()->nullable();
            $table->decimal('from_balance_after', 13)->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
