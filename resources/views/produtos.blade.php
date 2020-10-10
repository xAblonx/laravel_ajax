@extends('layout.app', ["current" => "produtos"])

@section('body')
  <div class="card border">
    <div class="card-body">
      <h5 class="card-title">Cadastro de Produtos</h5>
      <table id="tabelaProdutos" class="table table-ordered table-hover">
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
                  <select id="departamentoProduto" class="form-control"></select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Salvar</button>
              <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
  <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    function novoProduto() {
      $('#id').val('');
      $('#nomeProduto').val('');
      $('#precoProduto').val('');
      $('#quantidadeProduto').val('');
      $('#dlgProdutos').modal('show');
    }

    function carregarDepartamentos() {
        $.getJSON('/api/categorias', function (data) {
            for(i = 0; i < data.length; i++) {
                let opcao = '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
                $('#departamentoProduto').append(opcao);
            }
        });
    }

    function montarLinha(produto) {
        let linha = "<tr>" +
                        "<td>" + produto.id + "</td>" +
                        "<td>" + produto.nome + "</td>" +
                        "<td>" + produto.estoque + "</td>" +
                        "<td>" + produto.preco + "</td>" +
                        "<td>" + produto.categoria_id + "</td>" +
                        "<td>" +
                            '<button class="btn btn-sm btn-primary" onclick="editar(' + produto.id + ')">Editar</button>' +
                            '<button class="btn btn-sm btn-danger" onclick="apagar(' + produto.id + ')">Apagar</button>' +
                        "</td>" +
                    "</tr>";
        return linha;
    }

    function editar(id) {
        $.getJSON('/api/produtos/' + id, function (data) {
            $('#id').val(data.id);
            $('#nomeProduto').val(data.nome);
            $('#precoProduto').val(data.preco);
            $('#quantidadeProduto').val(data.estoque);
            $('#departamentoProduto').val(data.categoria_id);
            $('#dlgProdutos').modal('show');
        });
    }

    function apagar(id) {
        $.ajax({
            type: "DELETE",
            url: "/api/produtos/" + id,
            context: this,
            success: function() {
                console.log('Apagar OK');
                let linhas = $('#tabelaProdutos>tbody>tr');
                e = linhas.filter(function(i, elemento) {
                    return elemento.cells[0].textContent == id;
                });

                if(e)
                    e.remove();
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function carregarProdutos() {
        $.getJSON('/api/produtos', function (produtos) {
            for(let i = 0; i < produtos.length; i++) {
                let linha = montarLinha(produtos[i]);
                $('#tabelaProdutos>tbody').append(linha);
            }
        });
    }

    function criarProduto() {
        let produto = {
            nome: $('#nomeProduto').val(),
            preco: $('#precoProduto').val(),
            estoque: $('#quantidadeProduto').val(),
            categoria_id: $('#departamentoProduto').val()
        };

        $.post('/api/produtos', produto, function(data) {
            let produto = JSON.parse(data);
            let linha = montarLinha(produto);
            $('#tabelaProdutos>tbody').append(linha);
        });
    }

    function editarProduto() {
        let produto = {
            id: $('#id').val(),
            nome: $('#nomeProduto').val(),
            preco: $('#precoProduto').val(),
            estoque: $('#quantidadeProduto').val(),
            categoria_id: $('#departamentoProduto').val()
        };

        $.ajax({
            type: "PUT",
            url: "/api/produtos/" + produto.id,
            context: this,
            data: produto,
            success: function(data) {
                let produto = JSON.parse(data);
                let linhas = $('#tabelaProdutos>tbody>tr');
                let e = linhas.filter(function(i, elemento) {
                    return elemento.cells[0].textContent == produto.id;
                });

                if(e) {
                    e[0].cells[0].textContent = produto.id;
                    e[0].cells[1].textContent = produto.nome;
                    e[0].cells[2].textContent = produto.estoque;
                    e[0].cells[3].textContent = produto.preco;
                    e[0].cells[4].textContent = produto.categoria_id;
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    $('#formProduto').submit(function(event) {
        event.preventDefault();
        if($('#id').val() != '') {
            editarProduto();
        } else {
            criarProduto();
        }
        $('#dlgProdutos').modal('hide');
    });

    $(function() {
        carregarDepartamentos();
        carregarProdutos();
    });
  </script>
@endsection
