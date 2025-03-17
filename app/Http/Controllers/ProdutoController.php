<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $produtos = Produto::all();
            return response()->json($produtos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao listar produtos'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_categoria_produto' => 'required|integer|exists:tb_categoria_produto,id_categoria_planejamento',
            'nome_produto' => 'required|string|max:150',
            'valor_produto' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $produto = Produto::create([
                'id_categoria_produto' => $request->id_categoria_produto,
                'nome_produto' => $request->nome_produto,
                'valor_produto' => $request->valor_produto
            ]);

            return response()->json($produto, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $produto = Produto::findOrFail($id);
            return response()->json($produto, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'produto não encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_categoria_produto' => 'sometimes|integer|exists:tb_categoria_produto,id_categoria_planejamento',
            'nome_produto' => 'sometimes|string|max:150',
            'valor_produto' => 'sometimes|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $produto = Produto::findOrFail($id);
            $produto->update($request->only(['id_categoria_produto','nome_produto','valor_produto']));

            return response()->json($produto, 200);
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
            $produto = Produto::findOrFail($id);
            $produto->delete();

            return response()->json(['message' => 'produto deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'erro ao deleta produto'], 500);
        }
    }
}
