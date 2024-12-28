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
        Schema::create('action_users', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['blog', 'news']);
            $table->enum('action', ['like', 'dislike', 'favorite']);
            $table->integer('action_id');
            $table->integer('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_users');
    }
};
