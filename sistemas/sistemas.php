<?php
$pageScripts = ['sistemas.js']; // Apenas scripts deste módulo
require_once __DIR__ . '/../login/verifica_login.php';
include __DIR__ . '/../header.php';


?>

<div class="container mt-4">

  <div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-semibold">Sistemas utilizados pela COTI</h2>
    <button id="btnNovoSistema" class="btn btn-primary" aria-label="Cadastrar novo sistema">
      <i class="bi bi-plus-circle me-2"></i> Novo sistema
    </button>
  </div>



  <!-- Tabela -->
  <div class="card shadow-sm">
    <div class="card-body">
      <table id="tabelaSistemas" class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Nome do Sistema</th>
            <th>Área</th>
            <th>Responsável</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Local</th>
            <th>Status</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <!-- Linhas serão preenchidas dinamicamente via JavaScript -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Novo Sistema -->
<div class="modal fade" id="modalNovoSistema" tabindex="-1" aria-labelledby="modalNovoSistemaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formNovoSistema">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalNovoSistemaLabel">
            <i class="bi bi-plus-circle me-2"></i> Cadastrar novo sistema
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nome" class="form-label">Nome do Sistema</label>
              <input type="text" id="nome" class="form-control" name="nome" required>
            </div>
            <div class="col-md-6">
              <label for="area" class="form-label">Área</label>
              <input type="text" id="area" class="form-control" name="area" required>
            </div>
            <div class="col-md-6">
             <label for="responsavel" class="form-label">Responsável</label>
             <input type="text" id="responsavel" class="form-control" name="responsavel" required>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">E-mail</label>
              <input type="email" id="email" class="form-control" name="email" required>
            </div>
            <div class="col-md-6">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="text" id="telefone" class="form-control" name="telefone">
            </div>
            <div class="col-md-6">
             <label for="local" class="form-label">Local</label>
             <input type="text" id="local" class="form-control" name="local">
            </div>
            <div class="col-md-6">
              <label for="status" class="form-label">Status</label>
              <select id="status" class="form-select" name="status" required>
                <option value="">Selecione...</option>
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
