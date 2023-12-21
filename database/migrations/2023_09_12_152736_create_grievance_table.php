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
        Schema::create('grievance', function (Blueprint $table) {
            $table->uuid('grievance_id')->peimary();
            $table->uuid('user_id')->nullable();
            $table->string('grievance_num',255)->nullable();
            $table->string('lattitude',255);
            $table->string('longitude',255);
            $table->string('issue',255);
            $table->string('category',255);
            $table->string('locations',255);
            $table->string('status',255)->nullable();
            $table->string('complainants',255);
            $table->string('image_location',255);
            $table->string('image_ttd',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievance');
    }
};
