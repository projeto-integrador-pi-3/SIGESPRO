<?php 
$pageScripts = ['usuarios.js']; // Apenas scripts deste módulo

// require_once __DIR__ . '/../login/verifica_login.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
// exit;


require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['usuario_perfil'])) {
    header("Location: " . BASE_URL . "/login/login_form.php");
    exit;
}

// Se não for admin, exibe mensagem e interrompe o script
if ($_SESSION['usuario_perfil'] !== 'admin') {
    echo "<div style='padding:20px; font-family: Arial;'>
            <h2>Acesso Restrito</h2>
            <p>Você não tem permissão para acessar esta página.</p>
            <p>É necessário ser <strong>administrador</strong>.</p>
            <a href='" . BASE_URL . "/index.php'>Voltar ao início</a>
          </div>";
    exit;
}

include __DIR__ . '/../header.php';




?>

<h2 class="fw-semibold text-primary mb-4">Usuários do Sistema</h2>
<p class="text-secondary mb-4">
  Gerencie os usuários cadastrados no sistema SIGESPRO.
</p>

<!-- Campo de busca -->
<div class="input-group mb-4">
  <input type="text" id="campoBuscaUsuario" class="form-control" placeholder="Buscar usuário..." aria-label="Buscar usuário" />
  <button class="btn btn-outline-primary" type="button">
    <i class="bi bi-search"></i> Buscar
  </button>
</div>

<!-- Botão de novo usuário -->
<div class="text-end mb-3">
  <button id="btnNovoUsuario" class="btn btn-primary" aria-label="Cadastrar novo usuário">
    <i class="bi bi-plus-circle"></i> Novo Usuário
  </button>
</div>

<!-- Grid de usuários -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="containerUsuarios"></div>

<!-- Modal de Cadastro / Edição -->
<div class="modal fade" id="modalNovoUsuario" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formNovoUsuario" aria-label="Formulário de cadastro de usuário">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold text-primary">Cadastro de Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nomeUsuario" class="form-label">Nome</label>
              <input type="text" id="nomeUsuario" name="nome" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label for="emailUsuario" class="form-label">E-mail</label>
              <input type="email" id="emailUsuario" name="email" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label for="senhaUsuario" class="form-label">Senha</label>
              <input type="password" id="senhaUsuario" name="senha" class="form-control" required />
            </div>
            <div class="col-md-6">
              <label for="perfilUsuario" class="form-label">Perfil</label>
              <select id="perfilUsuario" name="perfil" class="form-select" required>
                <option value="">Selecione...</option>
                <option value="admin">Administrador</option>
                <option value="usuario">Usuário</option>
              </select>
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


<!-- <script>
document.addEventListener('DOMContentLoaded', () => {
    const btnNovo = document.getElementById('btnNovoUsuario');
    const modalEl = document.getElementById('modalNovoUsuario');
    const modal = new bootstrap.Modal(modalEl);

    btnNovo.addEventListener('click', () => {
        modal.show();
    });
});
</script> -->

<?php include __DIR__ . '/../footer.php'; ?>
