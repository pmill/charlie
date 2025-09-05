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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email', 254); // max length for an email is 254 characters according to RFC 5321
            $table->string('phone', 15)->nullable(); // numbers will be stored in E.164 standard format without the leading +
            $table->string('organisation')->nullable();
            $table->string('job_title')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->mediumText('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'email'], 'user_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
