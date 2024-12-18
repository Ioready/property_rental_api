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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('images')->nullable();
            $table->integer('is_active')->default(0);
            $table->string('plan')->default(0);
            $table->string('created_by')->default(0);
            $table->string('is_enable_login')->default(0);
            $table->string('plan_expire_date')->nullable();
            $table->string('trial_expire_date')->nullable();
            $table->integer('type')->default(0);
            $table->string('agent_id')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
