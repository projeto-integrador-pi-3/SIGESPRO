<?php 
$pageScripts = ['secretarias.js']; // Apenas scripts deste módulo
require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/login/verifica_login.php';

include $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/config.php';
?>

<!-- Título e descrição -->
<h2 class="fw-semibold text-primary mb-4">Unidades de TI das Secretarias</h2>
<p class="text-secondary mb-4">
  Aqui você encontra os contatos das equipes de Tecnologia da Informação de cada uma das Secretarias do Município de São Paulo.
</p>

<!-- Campo de busca -->
<div class="input-group mb-4">
  <input type="text" id="campoBuscaSecretaria" class="form-control" placeholder="Buscar Secretaria..." />
  <button class="btn btn-outline-primary" type="button">
    <i class="bi bi-search"></i> Buscar
  </button>
</div>

<!-- Botão de nova Secretaria -->
<div class="text-end mb-3">
  <button id="btnNovaSecretaria" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Nova Secretaria
  </button>
</div>

<!-- Grid de Secretarias -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="containerSecretarias"></div>

<!-- Modal de Cadastro / Edição -->
<div class="modal fade" id="modalNovaSecretaria" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formNovaSecretaria">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold text-primary">Cadastro de Secretaria</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nome da Secretaria</label>
              <input type="text" name="nome" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label class="form-label">Endereço</label>
              <input type="text" name="endereco" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label class="form-label">Telefone</label>
              <input type="text" name="telefone" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label class="form-label">E-mail</label>
              <input type="email" name="email" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label class="form-label">Responsável</label>
              <input type="text" name="responsavel" class="form-control" required />
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

<?php include $_SERVER['DOCUMENT_ROOT'] . '/projeto_integrador_ii/footer.php'; ?>
