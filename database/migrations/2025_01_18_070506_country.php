<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_countries', function (Blueprint $table) {
            $table->id(); // Equivalent to `id` column with AUTO_INCREMENT
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('name', 80)->unique();
            $table->string('continent', 50)->nullable();
            $table->string('slug', 250)->nullable();
            $table->string('country_name_seo', 80)->nullable();
            $table->string('country_code', 50)->nullable();
            $table->string('currency_code', 20)->nullable();
            $table->string('iso_code', 50)->nullable();
            $table->string('time_zone', 80)->nullable();
            $table->string('gmt_offset', 80)->nullable();
            $table->string('flag_code', 50)->nullable();
            $table->integer('phone_code');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('country_currency_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('ourOperation', ['On', 'Off'])->default('On');
            $table->boolean('is_destination')->default(false);
            $table->longText('is_nationality')->nullable();
            $table->longText('is_livingin')->nullable();
            $table->boolean('is_sticker')->default(false);
            $table->string('country_isd_code', 10)->nullable();
            $table->string('country_type', 4)->nullable();
            $table->string('featured_image', 255)->nullable();
            $table->string('latlogname', 255)->nullable();
            $table->string('latlogaddress', 255)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->default(0);
            $table->dateTime('deleted_date')->nullable();
            $table->string('lang', 10)->nullable();
            $table->string('banner_img', 255)->nullable();
            $table->string('tax_name', 100)->nullable();
            $table->decimal('tax_percentage', 10, 2)->nullable();
            $table->string('label', 255)->nullable();
            $table->string('online_process', 150)->default('N');
            $table->boolean('sticker_process')->default(false);
            $table->string('lat', 255)->nullable();
            $table->string('log', 255)->nullable();
            $table->string('long', 255)->nullable();
            $table->string('country_demonymic', 175)->nullable();
            $table->longText('is_nationality_sticker')->nullable();
            $table->longText('is_livingin_sticker')->nullable();
            $table->longText('description')->nullable();
            $table->longText('summary')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->longText('meta_description')->nullable();
            $table->text('meta_itemprop_name')->nullable();
            $table->longText('meta_itemprop_description')->nullable();
            $table->text('meta_og_title')->nullable();
            $table->longText('meta_og_description')->nullable();
            $table->text('meta_twitter_title')->nullable();
            $table->longText('meta_twitter_description')->nullable();
            $table->enum('is_valid_visa', ['Yes', 'No'])->nullable()->comment('For Turkey (Yes)');
            $table->boolean('refund_nationalties')->default(true);

            // Indexes
            $table->index('is_active', 'nia');
            $table->index('iso_code');
            $table->index('is_destination');
            $table->index('slug');
            $table->index('country_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_countries');
    }
};
