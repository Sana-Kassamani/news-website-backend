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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->constrained(table: 'users', indexName: 'user_id')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('news_item_id')
                    ->constrained(table: 'news_items', indexName: 'post_news_item_id')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string("content");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
