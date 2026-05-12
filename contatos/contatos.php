<?php
$pageScripts = ['contatos.js'];
require_once __DIR__ . '/../login/verifica_login.php';
include __DIR__ . '/../header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="fw-semibold text-primary mb-1">Contatos</h2>
    <p class="text-secondary mb-0">Subprefeituras, secretarias e fornecedores da COTI/SMSUB.</p>
  </div>
  <button id="btnNovoContato" class="btn btn-primary" aria-label="Cadastrar novo contato">
    <i class="bi bi-plus-circle"></i> Novo Contato
  </button>
</div>

<!-- Filtro por tipo + busca -->
<div class="d-flex flex-wrap gap-3 align-items-center mb-4">
  <div class="btn-group" role="group" aria-label="Filtrar por tipo">
    <button type="button" class="btn btn-outline-secondary active" data-filtro="">Todos</button>
    <button type="button" class="btn btn-outline-secondary" data-filtro="subprefeitura">Subprefeituras</button>
    <button type="button" class="btn btn-outline-secondary" data-filtro="secretaria">Secretarias</button>
    <button type="button" class="btn btn-outline-secondary" data-filtro="fornecedor">Fornecedores</button>
  </div>
  <input type="text" id="buscaContatos" class="form-control w-auto" placeholder="Buscar..." aria-label="Buscar contatos">
</div>

<!-- Container de cards -->
<div id="containerContatos" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"></div>

<!-- Modal cadastro/edição -->
<div class="modal fade" id="modalContato" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formContato" aria-label="Formulário de contato">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalContatoTitulo">Novo Contato</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="contatoId" name="id">

          <div class="row g-3">
            <div class="col-md-6">
              <label for="contatoTipo" class="form-label">Tipo</label>
              <select class="form-select" id="contatoTipo" name="tipo" required>
                <option value="">Selecione</option>
                <option value="subprefeitura">Subprefeitura</option>
                <option value="secretaria">Secretaria</option>
                <option value="fornecedor">Fornecedor</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="contatoNome" class="form-label">Nome</label>
              <input type="text" class="form-control" id="contatoNome" name="nome" required>
            </div>
            <div class="col-12">
              <label for="contatoEndereco" class="form-label">Endereço</label>
              <input type="text" class="form-control" id="contatoEndereco" name="endereco">
            </div>
            <div class="col-md-6">
              <label for="contatoTelefone" class="form-label">Telefone</label>
              <input type="text" class="form-control" id="contatoTelefone" name="telefone">
            </div>
            <div class="col-md-6">
              <label for="contatoEmail" class="form-label">E-mail</label>
              <input type="email" class="form-control" id="contatoEmail" name="email">
            </div>
            <div class="col-md-6">
              <label for="contatoResponsavel" class="form-label">Responsável</label>
              <input type="text" class="form-control" id="contatoResponsavel" name="responsavel">
            </div>

            <!-- Campos exclusivos de fornecedor -->
            <div id="camposFornecedor" class="col-12 d-none">
              <hr>
              <h6 class="text-secondary mb-3">Dados do Contrato</h6>
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="contatoSei" class="form-label">Número do Processo SEI</label>
                  <input type="text" class="form-control" id="contatoSei" name="numero_sei">
                </div>
                <div class="col-md-6">
                  <label for="contatoContrato" class="form-label">Número do Contrato</label>
                  <input type="text" class="form-control" id="contatoContrato" name="numero_contrato">
                </div>
                <div class="col-md-6">
                  <label for="contatoVigenciaInicio" class="form-label">Início da Vigência</label>
                  <input type="date" class="form-control" id="contatoVigenciaInicio" name="vigencia_inicio">
                </div>
                <div class="col-md-6">
                  <label for="contatoVigenciaFim" class="form-label">Fim da Vigência</label>
                  <input type="date" class="form-control" id="contatoVigenciaFim" name="vigencia_fim">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tabela invisível para DataTable -->
<table id="tabelaDataContatos" class="d-none">
  <thead>
    <tr>
      <th>Nome</th>
      <th>Tipo</th>
      <th>Telefone</th>
      <th>Email</th>
      <th>Responsável</th>
    </tr>
  </thead>
</table>

<?php include __DIR__ . '/../footer.php'; ?>
