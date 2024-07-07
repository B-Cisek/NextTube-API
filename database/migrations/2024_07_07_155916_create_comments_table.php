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
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('text');
            $table->bigInteger('likes')->default(0);
            $table->bigInteger('dislikes')->default(0);
            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('comments');
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('video_id')->constrained();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
