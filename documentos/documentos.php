<?php

$pageScripts = ['documentos.js']; // Apenas scripts deste módulo

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/login/verifica_login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/config.php';

?>

<div class="d-flex justify-content-between align-items-center mb-5">
  <h2 class="fw-semibold text-primary">Documentos da Coordenação de TI</h2>
  <button id="btnNovoDocumento" class="btn btn-primary">
    <i class="bi bi-upload"></i> Enviar Documento
  </button>
</div>



<!-- Lista de documentos -->
<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-hover align-middle" id="tabelaDocumentos">
      <thead class="table-light">
        <tr>
          <th><i class="bi bi-file-earmark-text"></i> Nome do Documento</th>
          <th>Categoria</th>
          <th>Responsável</th>
          <th>Última Atualização</th>
          <th class="text-center">Ações</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<!-- Modal de Upload -->
<div class="modal fade" id="modalNovoDocumento" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formNovoDocumento" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title text-primary fw-semibold">Enviar Novo Documento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nome do Documento</label>
            <input type="text" name="nome" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="categoria" class="form-select" required>
              <option value="">Selecione...</option>
              <option>Manuais</option>
              <option>Relatórios</option>
              <option>Procedimentos</option>
              <option>Planejamento</option>
              <option>Termo de Empréstimo</option>
              <option>Termo de Saída</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Responsável</label>
            <input type="text" name="responsavel" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Arquivo</label>
            <input type="file" name="arquivo" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="modalVisualizarDocumento" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-semibold text-primary">
          <i class="bi bi-file-earmark-text"></i> Visualizar Documento
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" style="height: 80vh;">
        <iframe id="iframeDocumento" src="" style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" id="btnBaixarDocumento">
          <i class="bi bi-download"></i> Baixar
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/footer.php'; ?>