<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProduto;
use App\Models\Produto;
use Illuminate\Support\Facades\Validator;

class CategoriaProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categorias_produtos = CategoriaProduto::all();
            return response()->json($categorias_produtos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao listar categorias de produtos'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomeCategoria' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $categoria_produto = CategoriaProduto::create([
                'nome_categoria' => $request->nomeCategoria
            ]);

            $categorias_produtos = CategoriaProduto::all();
            return response()->json($categorias_produtos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao criar categoria de produto'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $categoria_produto = CategoriaProduto::findOrFail($id);
            return response()->json($categoria_produto, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'categoria de produto não encontrada'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nomeCategoria' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $categoria_produto = CategoriaProduto::findOrFail($id);
            $categoria_produto->update(['nome_categoria' => $request->input('nomeCategoria')]);

            $categorias_produtos = CategoriaProduto::all();
            return response()->json($categorias_produtos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' =>$e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $categoria_produto = CategoriaProduto::find($id);
            if (!$categoria_produto) {
                return response()->json(['error' => 'Categoria não encontrada.'], 404);
            }
    
            if (Produto::where('id_categoria_produto', $id)->exists()) {
                return response()->json(['error' => 'Não é possível excluir esta categoria, pois existem produtos vinculados.'], 400);
            }

            $categoria_produto->delete();
    
            $categorias_produtos = CategoriaProduto::all();
            return response()->json($categorias_produtos, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno: ' . $e->getMessage()], 500);
        }
    }
    
}
