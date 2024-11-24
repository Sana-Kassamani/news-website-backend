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
        Schema::table('news_items', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->change();
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_items', function (Blueprint $table) {
            $table->string('attachment_path')->nullable(false)->change();
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->string('attachment_path')->nullable(false)->change();
        });
    }
};
