<?php 
$pageScripts = ['subprefeituras.js']; // Apenas scripts deste módulo
require_once __DIR__ . '/../login/verifica_login.php';
include __DIR__ . '/../header.php';

?>

<h2 class="fw-semibold text-primary mb-4">Unidades de TI e CPDU das Subprefeituras</h2>
<p class="text-secondary mb-4">
  Aqui você encontra os contatos das equipes de Tecnologia da Informação e CPDU de cada uma das 32 Subprefeituras do Município de São Paulo.
</p>

<div class="d-flex justify-content-between align-items-center mb-4">
    <button id="btnNovaSub" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nova Subprefeitura
    </button>
</div>

<!-- Container para os cards -->
<div id="containerSubprefeituras" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"></div>

<!-- Modal para cadastrar/editar subprefeitura -->
<div class="modal fade" id="modalSub" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formSub">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Nova Subprefeitura</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="subId" name="id">

          <div class="mb-3">
            <label for="nome" class="form-label">Nome da Subprefeitura</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" required>
          </div>
          <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="responsavel" class="form-label">Responsável</label>
            <input type="text" class="form-control" id="responsavel" name="responsavel" required>
          </div>
          <div class="mb-3">
            <label for="area" class="form-label">Área</label>
            <select class="form-select" id="area" name="area" required>
              <option value="">Selecione</option>
              <option value="TI">TI</option>
              <option value="CPDU">CPDU</option>
            </select>
          </div>

          <!-- Google Maps API -->
          <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBa0tsYGve4tIwERQ0438tyuQvkEHJAJT4&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tabela invisível apenas para DataTable -->
<table id="tabelaDataSub" class="d-none">
  <thead>
    <tr>
      <th>Nome</th>
      <th>Endereço</th>
      <th>Telefone</th>
      <th>Email</th>
      <th>Responsável</th>
      <th>Área</th>
    </tr>
  </thead>
</table>

<?php include __DIR__ . '/../footer.php'; ?>
