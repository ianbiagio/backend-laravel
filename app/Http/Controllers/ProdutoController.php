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
            $produtos_com_categoria = $this->get_produtos_x_produtosCategorias();
            return response()->json($produtos_com_categoria, 200);
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
            'idCategoriaProduto' => 'required|integer|exists:tb_categoria_produto,id_categoria_planejamento',
            'nomeProduto' => 'required|string|max:150',
            'valorProduto' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $produto = Produto::create([
                'id_categoria_produto' => $request->idCategoriaProduto,
                'nome_produto' => $request->nomeProduto,
                'valor_produto' => $request->valorProduto
            ]);

            $produtos_com_categoria = $this->get_produtos_x_produtosCategorias();
            return response()->json($produtos_com_categoria, 200);
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
            'id_categoria_produto' => 'nullable|integer|exists:tb_categoria_produto,id_categoria_planejamento',
            'nome_produto' => 'nullable|string|max:150',
            'valor_produto' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $produto = Produto::findOrFail($id);
            // $produto->update($request->only(['id_categoria_produto','nome_produto','valor_produto']));
            $produto->update(['nome_produto' => $request->input('nomeProduto'),'id_categoria_produto'=>$request->input('idCategoriaProduto'),'valor_produto'=>$request->input('valorProduto')]);
            $produtos_com_categoria = $this->get_produtos_x_produtosCategorias();
            return response()->json($produtos_com_categoria, 200);
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

            $produtos_com_categoria = $this->get_produtos_x_produtosCategorias();
            return response()->json($produtos_com_categoria, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    private function get_produtos_x_produtosCategorias(){
        $produtos = Produto::with('categoriaProduto:id_categoria_planejamento,nome_categoria')->get();
    
        $produtos_com_categoria = $produtos->map(function ($produto) {
            return [
                'id_produto' => $produto->id_produto,
                'id_categoria_produto' => $produto->id_categoria_produto,
                'data_cadastro' => $produto->data_cadastro,
                'nome_produto' => $produto->nome_produto,
                'valor_produto' => $produto->valor_produto,
                'created_at' => $produto->created_at,
                'updated_at' => $produto->updated_at,
                'id_categoria_planejamento' => $produto->categoriaProduto->id_categoria_planejamento ?? null,
                'nome_categoria' => $produto->categoriaProduto->nome_categoria ?? null,
            ];
        });

        return $produtos_com_categoria;
    }
}
