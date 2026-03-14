<?php
$pageScripts = ['procedimentos.js']; // Apenas scripts deste módulo
require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/login/verifica_login.php';

include $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/config.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold text-primary">Procedimentos da Coordenação de TI</h2>
    <button id="btnNovoProcedimento" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Procedimento
    </button>
</div>

<!-- Campo de busca -->
<div class="input-group mb-4">
    <input type="text" class="form-control" placeholder="Pesquisar procedimento..." />
    <button class="btn btn-outline-primary" type="button">Buscar</button>
</div>

<!-- Container para cards preenchidos via JS -->
<div id="containerProcedimentos" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"></div>

<!-- Modal Novo / Editar Procedimento -->
<div class="modal fade" id="modalNovoProcedimento" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formNovoProcedimento">
        <div class="modal-header">
          <h5 class="modal-title">Novo Procedimento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
          </div>
          <div class="mb-3">
            <label for="resumo" class="form-label">Resumo</label>
            <input type="text" class="form-control" id="resumo" name="resumo" required>
          </div>
          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" id="tipo" name="tipo" required>
              <option value="">Selecione</option>
              <option value="Suporte">Suporte</option>
              <option value="Infraestrutura">Infraestrutura</option>
              <option value="Administração">Administração</option>
              <option value="Manutenção">Manutenção</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="descricao" class="form-label">Descrição detalhada</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="6" required></textarea>
          </div>
          <input type="hidden" name="id" id="procedimentoId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Ver Detalhes -->
<div class="modal fade" id="modalDetalhesProcedimento" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detalhesTitulo"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="detalhesDescricao"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnEditarDetalhes">Editar</button>
        <button type="button" class="btn btn-danger" id="btnExcluirDetalhes">Excluir</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Tabela invisível apenas para DataTable -->

<table id="tabelaProcedimentos" class="table d-none">
  <thead>
    <tr>
      <th>Título</th>
      <th>Resumo</th>
      <th>Tipo</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/footer.php'; ?>
