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
        Schema::create('task_attachments', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary()->autoIncrement();
            $table->unsignedInteger('task_id')->index();
            $table->string('file_name', 64);
            $table->string('file_path', 120);
            $table->unsignedInteger('uploaded_by')->index();
            $table->unsignedTinyInteger('file_confrim')->default(0);
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_attachments');
    }
};
