<?php
$pageScripts = ['templates.js'];
require_once __DIR__ . '/../login/verifica_login.php';

if ($_SESSION['usuario_perfil'] !== 'admin') {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "/documentos/documentos.php");
    exit;
}

include __DIR__ . '/../header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="fw-semibold text-primary mb-1">Templates de Documentos</h2>
    <p class="text-secondary mb-0">Crie e gerencie modelos reutilizáveis para geração de documentos.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= BASE_URL ?>/documentos/documentos.php" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <button id="btnNovoTemplate" class="btn btn-primary">
      <i class="bi bi-plus-circle"></i> Novo Template
    </button>
  </div>
</div>

<div id="containerTemplates" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
  <p class="text-secondary">Carregando templates...</p>
</div>

<!-- Modal criar/editar template -->
<div class="modal fade" id="modalTemplate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="formTemplate">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalTemplateTitulo">Novo Template</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Nome do Template</label>
              <input type="text" class="form-control" id="templateNome" name="nome" required placeholder="Ex: Termo de Empréstimo de Equipamento">
            </div>
            <div class="col-md-6">
              <label class="form-label">Categoria</label>
              <select class="form-select" id="templateCategoria" name="categoria" required>
                <option value="">Selecione</option>
                <option value="Termo de Empréstimo">Termo de Empréstimo</option>
                <option value="Termo de Saída">Termo de Saída</option>
                <option value="Manuais">Manuais</option>
                <option value="Relatórios">Relatórios</option>
                <option value="Procedimentos">Procedimentos</option>
                <option value="Planejamento">Planejamento</option>
              </select>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label">
              Conteúdo do Template
              <span class="text-muted fw-normal ms-1">— use <code>{{nome_da_variavel}}</code> para campos preenchíveis</span>
            </label>
            <textarea id="templateConteudo" name="conteudo"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar Template</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
