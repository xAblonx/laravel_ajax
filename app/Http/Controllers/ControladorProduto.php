<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ControladorProduto extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView() {
        return view('produtos');
    }

    public function index() {
        $produtos = Produto::all();
        return $produtos->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produto = new Produto();
        $produto->nome = $request->input('nome');
        $produto->preco = $request->input('preco');
        $produto->estoque = $request->input('estoque');
        $produto->categoria_id = $request->input('categoria_id');
        $produto->save();

        return $produto->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = Produto::find($id);

        if(isset($produto)) {
            return $produto->toJson();
        }

        return response('Produto não encontrado', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);

        if(isset($produto)) {
            $produto->nome = $request->input('nome');
            $produto->preco = $request->input('preco');
            $produto->estoque = $request->input('estoque');
            $produto->categoria_id = $request->input('categoria_id');
            $produto->save();

            return $produto->toJson();
        }

        return response('Produto não encontrado', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);

        if(isset($produto)) {
            $produto->delete();
            return response('OK', 200);
        }

        return response('Produto não encontrado', 404);
    }
}
