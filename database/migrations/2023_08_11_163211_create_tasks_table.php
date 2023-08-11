<?php

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
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
            $table->foreignId('workspace_id')->constrained('workspaces');
            $table->foreignId('project_id')->constrained('projects')->nullable();
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('assignee_id')->constrained('users')->nullable();
            $table->string('title');
            $table->text('description');
            $table->date('due_date')->nullable();
            $table->enum('priority', array_column(TaskPriority::cases(), 'value'))->default(TaskPriority::None->value);
            $table->enum('status', array_column(TaskStatus::cases(), 'name'))->default(TaskStatus::Backlog->name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
