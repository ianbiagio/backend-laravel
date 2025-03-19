<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $table = 'tb_categoria_produto';

   protected $primaryKey = 'id_categoria_planejamento';

   protected $fillable = [
       'nome_categoria'
   ];
}
