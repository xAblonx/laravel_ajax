@extends('layout.app', ["current" => "produtos"])

@section('body')
  <div class="card border">
    <div class="card-body">
      <h5 class="card-title">Cadastro de Produtos</h5>
      <table class="table table-ordered table-hover">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <th>Departamento</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <button class="btn btn-primary btn-sm" role="button" onclick="novoProduto()">Novo Produto</button>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="dlgProdutos">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form id="formProduto" class="form-horizontal">
            <div class="modal-header">
              <h5 class="modal-title">Novo Produto</h5>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id" class="form-control">
              <div class="form-group">
                <label for="nomeProduto" class="control-label">Nome do Produto</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="nomeProduto" placeholder="Nome do produto">
                </div>
              </div>
              <div class="form-group">
                <label for="precoProduto" class="control-label">Preço</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="precoProduto" placeholder="Preço do produto">
                </div>
              </div>
              <div class="form-group">
                <label for="quantidadeProduto" class="control-label">Quantidade</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="quantidadeProduto" placeholder="Quantidade do produto">
                </div>
              </div>
              <div class="form-group">
                <label for="departamentoProduto" class="control-label">Departamento</label>
                <div class="input-group">
                  <select name="" id="departamentoProduto" class="form-control"></select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Salvar</button>
              <button type="cancel" class="btn btn-secondary" data-dissmiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
  <script type="text/javascript">
    function novoProduto() {
      $('#id').val('');
      $('#nomeProduto').val('');
      $('#precoProduto').val('');
      $('#quantidadeProduto').val('');
      $('#dlgProdutos').modal('show');
    }
  </script>
@endsection