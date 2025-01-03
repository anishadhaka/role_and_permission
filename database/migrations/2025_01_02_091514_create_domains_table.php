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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain_name');
            $table->string('company_name');
            $table->string('mail_header');
            $table->string('mail_footer');
            $table->string('server_address');
            $table->string('port');
            $table->string('authentication');
            $table->string('user_name');
            $table->integer('password');
            $table->integer('to_mail_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
