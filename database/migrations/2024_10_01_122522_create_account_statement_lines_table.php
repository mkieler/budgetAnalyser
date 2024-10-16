<?php

use App\Models\AccountStatement;
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
        Schema::create('account_statement_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AccountStatement::class);
            $table->date('date');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->boolean('exclude')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_statement_lines');
    }
};
