<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_cities', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('state_id');
            $table->string('name', 80);
            $table->boolean('is_capital')->default(0);
            $table->string('slug', 250)->nullable();
            $table->text('intro')->nullable();
            $table->string('time_to_visit', 255)->nullable();
            $table->longText('description')->nullable();
            $table->string('thumb_image', 255)->nullable();
            $table->string('banner_image', 255)->nullable();
            $table->string('currency', 100)->nullable();
            $table->string('language', 255)->nullable();
            $table->string('latlogname', 255)->nullable();
            $table->string('latlogaddress', 255)->nullable();
            $table->string('iso_code', 255)->nullable();
            $table->text('seo_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('lat', 100)->nullable();
            $table->string('log', 100)->nullable();
            $table->boolean('is_active')->default(1);
            $table->enum('ourOperation', ['On', 'Off'])->default('On');
            $table->datetime('created_date')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->datetime('updated_date')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->default(0);
            $table->datetime('deleted_date')->nullable();
            $table->string('lang', 10)->default('en');

            // Indexes
            $table->index('country_id');
            $table->index('state_id');
            $table->index('is_active');
            $table->index('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_cities');
    }
};
