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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no');
            $table->string('property');
            $table->string('unit')->nullable();
            $table->string('issue_type')->nullable();
            $table->string('maintainer')->nullable();
            $table->string('description')->nullable();
            $table->string('images')->nullable();
            $table->enum('status',['Accepted','Open','Pending','Resolved','Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
