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
        Schema::table('tb_produto', function (Blueprint $table) {
            $table->dateTime('data_cadastro')->default(now())->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_produto', function (Blueprint $table) {
            Schema::table('tb_produto', function (Blueprint $table) {
                $table->dateTime('data_cadastro')->nullable(false)->change();
            });
        });
    }
};
