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
        Schema::create('budget_item_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\BudgetItem::class);
            $table->foreignIdFor(\App\Models\BudgetItemLineCategory::class)->nullable();
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_item_lines');
    }
};
