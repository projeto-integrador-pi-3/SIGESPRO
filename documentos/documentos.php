<?php

$pageScripts = ['documentos.js']; // Apenas scripts deste módulo

require_once __DIR__ . '/../login/verifica_login.php';
include __DIR__ . '/../header.php';


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
      <form id="formNovoDocumento" enctype="multipart/form-data" aria-label="Formulário de envio de documento">
        <div class="modal-header">
          <h5 class="modal-title text-primary fw-semibold">Enviar Novo Documento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="nomeDocumento" class="form-label">Nome do Documento</label>
            <input type="text" id="nomeDocumento" name="nome" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="categoriaDocumento" class="form-label">Categoria</label>
            <select id="categoriaDocumento" name="categoria" class="form-select" required>
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
            <label for="responsavelDocumento" class="form-label">Responsável</label>
            <input type="text" id="responsavelDocumento" name="responsavel" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="arquivoDocumento" class="form-label">Arquivo</label>
            <input type="file" id="arquivoDocumento" name="arquivo" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" required>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
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


<?php include __DIR__ . '/../footer.php'; ?>