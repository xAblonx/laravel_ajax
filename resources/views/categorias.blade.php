@extends('layout.app', ["current" => "categorias"])

@section('body')
  <div class="card border">
    <div class="card-body">
      <h5 class="card-title">Cadastro de Categorias</h5>
      @if(count($categorias) > 0)
        <table class="table table-ordered table-hover">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nome da Categoria</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categorias as $categoria)
              <tr>
                <td>{{ $categoria->id }}</td>
                <td>{{ $categoria->nome }}</td>
                <td>
                  <a href="/categorias/editar/{{ $categoria->id }}" class="btn btn-primary btn-sm">Editar</a>
                  <a href="/categorias/apagar/{{ $categoria->id }}" class="btn btn-danger btn-sm">Apagar</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
    <div class="card-footer">
      <a href="/categorias/novo" class="btn btn-primary btn-sm" role="button">Nova Categoria</a>
    </div>
  </div>
@endsection