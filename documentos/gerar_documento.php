<?php
$pageScripts = ['gerar_documento.js'];
require_once __DIR__ . '/../login/verifica_login.php';
include __DIR__ . '/../header.php';
?>
<!-- html2pdf.js via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="fw-semibold text-primary mb-1">Gerar Documento</h2>
    <p class="text-secondary mb-0">Escolha um template, preencha os campos e gere o documento.</p>
  </div>
  <a href="<?= BASE_URL ?>/documentos/documentos.php" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Voltar
  </a>
</div>

<!-- Passo 1: Selecionar template -->
<div id="stepSelecionar">
  <h5 class="mb-3">1. Selecione um template</h5>
  <div id="containerSelecionarTemplate" class="row row-cols-1 row-cols-md-3 g-3">
    <p class="text-secondary">Carregando templates...</p>
  </div>
</div>

<!-- Passo 2: Preencher variáveis -->
<div id="stepPreencher" class="d-none">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">2. Preencha os campos</h5>
    <button id="btnVoltarSelecao" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Escolher outro template
    </button>
  </div>
  <div class="row g-4">
    <div class="col-lg-4">
      <div class="card shadow-sm">
        <div class="card-header bg-light fw-semibold">Campos do documento</div>
        <div class="card-body">
          <form id="formVariaveis">
            <div id="camposVariaveis"></div>
            <hr>
            <label class="form-label">Nome do documento</label>
            <input type="text" class="form-control mb-3" id="nomeDocumento" required placeholder="Ex: Termo João Silva 2026">
            <div class="d-grid gap-2">
              <button type="button" id="btnPrevisualizar" class="btn btn-outline-primary">
                <i class="bi bi-eye"></i> Pré-visualizar
              </button>
              <button type="button" id="btnGerarSalvar" class="btn btn-success" disabled>
                <i class="bi bi-file-earmark-arrow-down"></i> Gerar e Salvar PDF
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-light fw-semibold">Pré-visualização</div>
        <div class="card-body p-4">
          <div id="previewConteudo" class="text-secondary fst-italic">
            Preencha os campos ao lado e clique em "Pré-visualizar".
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Spinner de geração -->
<div id="spinnerGerar" class="d-none text-center py-5">
  <div class="spinner-border text-primary" role="status"></div>
  <p class="mt-3 text-secondary">Gerando e salvando o documento...</p>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
