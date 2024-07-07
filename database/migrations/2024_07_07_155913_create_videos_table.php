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
        Schema::create('videos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('description');
            $table->bigInteger('likes')->default(0);
            $table->bigInteger('dislikes')->default(0);
            $table->bigInteger('view_count')->default(0);
            $table->foreignUuid('thumbnail_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('channel_id')->constrained();
            $table->foreignUuid('playlist_id')->constrained();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
