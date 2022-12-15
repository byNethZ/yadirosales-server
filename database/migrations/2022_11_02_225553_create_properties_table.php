<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->integer('list_number')->nullable();
            $table->char('approved', 1)->nullable();
            $table->char('type', 2)->nullable();
            $table->dateTime('timestamp')->nullable();
            $table->char('public', 1)->nullable();
            $table->dateTime('modify_timestamp')->nullable();
            $table->integer('picture_count')->nullable();
            $table->char('subtype', 100)->nullable();
            $table->char('status', 100)->nullable();
            //$table->decimal('price', $precision = 15, $scale = 2)->nullable();
            $table->char('price', 15)->nullable();
            $table->char('street_number', 10)->nullable();
            $table->char('street', 30)->nullable();
            $table->char('street_suffix', 100)->nullable();
            $table->char('city', 100)->nullable();
            $table->char('state', 100)->nullable();
            $table->char('county', 100)->nullable();
            $table->char('zipcode', 100)->nullable();
            //$table->decimal('latitude', $precision = 11, $scale = 9)->nullable();
            $table->char('latitude',11)->nullable();
            //$table->decimal('longitude', $precision = 11, $scale = 8)->nullable();
            $table->char('longitude', 11)->nullable();
            //$table->decimal('sq_total', $precision = 10, $scale = 5)->nullable();
            $table->char('sq_total', 10)->nullable();
            $table->integer('year_built')->nullable();
            $table->char('lot_size', 50)->nullable();
            //$table->decimal('acres', $precision = 10, $scale = 5)->nullable();
            $table->char('acres', 10)->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('bedrooms')->nullable();
            //$table->decimal('baths', $precision = 7, $scale = 2)->nullable();
            $table->char('baths', 7)->nullable();
            $table->integer('baths_full')->nullable();
            $table->integer('baths_mid')->nullable();
            //$table->decimal('taxes', $precision = 11, $scale = 2)->nullable();
            $table->char('taxes', 11)->nullable();
            $table->char('subdivision', 100)->nullable();
            $table->char('taxmap', 50)->nullable();
            $table->char('legal_desc', 150)->nullable();
            $table->char('deed_page', 20)->nullable();
            $table->char('deed_book', 20)->nullable();
            $table->char('elementary_school', 100)->nullable();
            $table->char('middle_school', 100)->nullable();
            $table->char('high_school', 100)->nullable();
            $table->char('hoa_fee', 20)->nullable();
            $table->text('directions')->nullable();
            $table->char('auction', 100)->nullable();
            $table->char('home_warranty', 100)->nullable();
            $table->char('builders_warranty', 100)->nullable();
            $table->text('public_remarks')->nullable();
            //$table->decimal('monthly_rent', $precision = 15, $scale = 2)->nullable();
            $table->char('monthly_rent',15)->nullable();
            //$table->decimal('units', $precision = 15, $scale = 2)->nullable();
            $table->char('units',15)->nullable();
            //$table->decimal('fireplace_list', $precision = 15, $scale = 2)->nullable();
            $table->char('fireplace_list',15)->nullable();
            $table->char('pets_allowed', 100)->nullable();

            $table->text('garage_parking')->nullable();
            $table->text('owner')->nullable();

            $table->text('gf_appliances')->nullable();
            $table->text('basement')->nullable();
            $table->text('bed_bath')->nullable();
            $table->text('brick_stone')->nullable();
            $table->text('gf_community_features')->nullable();
            $table->text('cooling')->nullable();
            $table->text('description')->nullable();
            $table->text('dining')->nullable();
            $table->text('documents')->nullable();
            $table->text('gf_equipment')->nullable();
            $table->text('gf_exterior')->nullable();
            $table->text('exterior_features')->nullable();
            $table->text('financing_available')->nullable();
            $table->text('gf_fireplace')->nullable();
            $table->text('floors')->nullable();
            $table->text('gf_foundation')->nullable();
            $table->text('gf_furnished')->nullable();
            $table->text('gf_garage')->nullable();
            $table->text('gf_green_features')->nullable();
            $table->text('heating')->nullable();
            $table->text('interior')->nullable();
            $table->text('lease_terms')->nullable();
            $table->text('gf_lot_description')->nullable();
            $table->text('gf_new_construction')->nullable();
            $table->text('owner_pays')->nullable();
            $table->text('pool')->nullable();
            $table->text('possession')->nullable();
            $table->text('roofing')->nullable();
            $table->text('gf_rooms')->nullable();
            $table->text('showing')->nullable();
            $table->text('gf_special_needs')->nullable();
            $table->text('style')->nullable();
            $table->text('tenant_pays')->nullable();
            $table->text('type_sale')->nullable();
            $table->text('utilities')->nullable();
            $table->text('water_sewer')->nullable();
            $table->text('windows')->nullable();

            $table->text('existing_financing')->nullable();
            $table->text('unit_one_features')->nullable();
            $table->text('unit_two_features')->nullable();
            $table->text('unit_three_features')->nullable();
            $table->text('unit_four_features')->nullable();

            $table->text('clear_percent')->nullable();
            $table->text('adjacent_use')->nullable();
            $table->text('docs_file')->nullable();
            $table->text('flood_zone')->nullable();
            $table->text('improvements')->nullable();
            $table->text('options')->nullable();
            $table->text('road')->nullable();
            $table->text('shape')->nullable();
            $table->text('structures')->nullable();

            $table->char('listing_member_shortid', 15)->nullable();
            $table->char('colisting_member_shortid', 15)->nullable();
            $table->char('selling_member_shortid', 15)->nullable();
            $table->char('coselling_member_shortid', 15)->nullable();
            $table->char('listing_member_name', 122)->nullable();
            $table->char('colisting_member_name', 122)->nullable();
            $table->char('selling_member_name', 122)->nullable();
            $table->char('coselling_member_name', 122)->nullable();
            $table->char('listing_office_name', 150)->nullable();
            $table->char('selling_office_name', 150)->nullable();
            $table->char('colisting_office_name', 150)->nullable();
            $table->char('coselling_office_name', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
