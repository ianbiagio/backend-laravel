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
        Schema::create('tb_categoria_produto', function (Blueprint $table) {
            $table->id('id_categoria_planejamento');
            $table->string('nome_categoria', 150);
            $table->timestamps();
            $table->primary('id_categoria_planejamento', 'PK_tb_categoria_produto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_categoria_produto');
    }
};
