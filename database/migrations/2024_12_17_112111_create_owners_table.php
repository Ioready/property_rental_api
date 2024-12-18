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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('contact_number');
            // $table->string('date');
            // $table->string('cea_registration_number');
            // $table->string('agency_name');
            // $table->string('city');
            // $table->string('state');
            // $table->string('address');
            $table->string('email_address');
            // $table->string('password');
            // $table->string('profile_picture');
            // $table->string('verification_document');
            // $table->string('year_of_experience');
            // $table->string('residential');
            // $table->string('commercial');
            // $table->string('land');
            // $table->string('other');
            // $table->string('area_of_operation');
            // $table->string('terms_and_conditions');
            $table->string('ticket_subject');
            $table->string('type');
            $table->string('priority');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
