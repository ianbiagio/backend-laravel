<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProduto;
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

            return response()->json($categoria_produto, 201);
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
            'nome_categoria' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $categoria_produto = CategoriaProduto::findOrFail($id);
            $categoria_produto->update($request->only(['nome_categoria']));

            return response()->json($categoria_produto, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao atualizar categoria do produto'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $categoria_produto = CategoriaProduto::findOrFail($id);
            $categoria_produto->delete();

            return response()->json(['message' => 'categoria de produto deletada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao deletar categoria de produto'], 500);
        }
    }
}
