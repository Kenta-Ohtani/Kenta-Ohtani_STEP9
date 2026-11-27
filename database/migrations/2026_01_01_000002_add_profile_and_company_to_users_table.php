<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('name_kanji', 255)->after('name');
            $table->string('name_kana', 255)->nullable()->after('name_kanji');
            $table->foreignId('company_id')
                ->nullable()
                ->after('password')
                ->constrained('companies')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('company_id');
            $table->dropColumn(['name_kanji', 'name_kana']);
        });
    }
};
