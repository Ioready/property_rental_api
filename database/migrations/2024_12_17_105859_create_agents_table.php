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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('contact_number');
            $table->string('date')->nullable();
            $table->string('cea_registration_number')->nullable();
            $table->string('agency_name')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('email_address');
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->string('verification_document')->nullable();
            $table->string('year_of_experience')->nullable();
            $table->string('residential')->nullable();
            $table->string('commercial')->nullable();
            $table->string('land')->nullable();
            $table->string('other')->nullable();
            $table->string('area_of_operation')->nullable();
            $table->string('terms_and_conditions')->nullable();
            $table->string('ticket_subject')->nullable();
            $table->string('type')->nullable();
            $table->string('priority')->nullable();
            $table->enum('status',['Initial Contact','Generated','Qualified'])->default('Initial Contact');;
            $table->enum('approve_status',['approved','reject','pending'])->default('pending');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
