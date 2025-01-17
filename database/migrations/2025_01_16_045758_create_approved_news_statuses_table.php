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
        Schema::create('approved_news_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('designation_id');
            $table->integer('news_id');
            $table->integer('approvel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approved_news_statuses');
    }
};
