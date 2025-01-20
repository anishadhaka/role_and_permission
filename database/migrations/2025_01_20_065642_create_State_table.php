<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_states', function (Blueprint $table) {
            $table->id(); // Equivalent to `id` column with AUTO_INCREMENT
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('name', 80);
            $table->boolean('is_capital')->default(false);
            $table->string('slug', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('ourOperation', ['On', 'Off'])->default('On');
            $table->dateTime('created_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->default(0);
            $table->dateTime('deleted_date')->nullable();
            $table->string('lang', 10)->nullable();
            $table->string('latlogname', 255)->nullable();
            $table->string('latlogaddress', 255)->nullable();
            $table->string('iso_code', 255)->nullable();
            $table->string('lat', 255)->nullable();
            $table->string('log', 255)->nullable();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade'); // Assuming a `countries` table exists
            $table->index('country_id');
            $table->index('name');
            $table->index('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_states');
    }
};
