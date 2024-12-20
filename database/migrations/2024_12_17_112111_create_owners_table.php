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
            $table->string('owner_type');
            $table->string('full_name');
            $table->string('contact_number');
            $table->string('date')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email_address');
            $table->string('password');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('company_registration_number_uen')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('same_as_address')->nullable();
            $table->string('verification_document')->nullable();
            $table->string('terms_and_conditions')->nullable();
            $table->string('ticket_subject')->nullable();
            $table->string('type')->nullable();
            $table->string('priority')->nullable();
            $table->enum('status',['Initial Contact','Generated','Qualified'])->default('Initial Contact');
            $table->string('assign_package')->nullable();
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
