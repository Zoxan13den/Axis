<?php

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
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
        if (Schema::hasTable('tasks')) {
            echo 'tasks exist' . PHP_EOL;
            return;
        }

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('name', 24);
            $table->text('description');
            $table->enum('priority', [TaskPriorityEnum::LOW->value, TaskPriorityEnum::MEDIUM->value, TaskPriorityEnum::HIGH->value])
                ->default(TaskPriorityEnum::MEDIUM->value);
            $table->enum('status', [TaskStatusEnum::OPEN->value, TaskStatusEnum::PROCESSING->value, TaskStatusEnum::FINISHED->value])
                ->default(TaskStatusEnum::OPEN->value);
            $table->dateTime('deadline');
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
