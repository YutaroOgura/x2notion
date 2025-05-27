<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_responses', function (Blueprint $table) {
            $table->id();
            $table->text('user_message');
            $table->text('ai_response');
            $table->string('source_platform')->default('slack');
            $table->string('user_id')->nullable();
            $table->timestamp('response_time');
            $table->integer('tokens_used')->nullable();
            $table->text('notion_query')->nullable();
            $table->string('status')->default('completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_responses');
    }
};