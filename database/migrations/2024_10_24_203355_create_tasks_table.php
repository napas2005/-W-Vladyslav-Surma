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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('priority_id')->constrained('priorities');
            $table->date('due_date')->nullable();
            $table->string('slug');
            $table->tinyInteger('is_completed')->default(0);
            $table->timestamps();
        });

        Schema::create('task_financials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10);
            $table->date('transaction_date')->nullable();
            $table->timestamps();
        });

        Schema::create('financial_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('task_financial_id')->constrained('task_financials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_task');
        Schema::dropIfExists('task_financials');
        Schema::dropIfExists('tasks');
    }
};
