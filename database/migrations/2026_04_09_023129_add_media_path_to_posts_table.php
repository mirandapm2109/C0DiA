<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->text('content')->nullable();
                $table->string('media_path')->nullable();
                $table->timestamps();
            });
        } elseif (!Schema::hasColumn('posts', 'media_path')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('media_path')->nullable()->after('content');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
