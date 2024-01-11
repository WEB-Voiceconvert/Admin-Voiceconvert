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
        Schema::table('voices', function (Blueprint $table) {
            $table->unsignedBigInteger('id_event')->nullable()->change();
            $table->unsignedBigInteger('id_berita')->nullable()->after('id_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voices', function (Blueprint $table) {
            $table->unsignedBigInteger('id_event')->nullable(false)->change();
            $table->dropColumn('id_berita');
        });
    }
};
