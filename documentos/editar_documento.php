<?php
require '../conexao.php';
require_once __DIR__ . '/../login/verifica_login.php';
include __DIR__ . '/../header.php';

$id = $_GET['id'] ?? '';

if (!$id) {
  echo "<div class='alert alert-danger'>Documento não encontrado.</div>";
  exit;
}

$stmt = $conn->prepare("SELECT * FROM documentos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$doc = $stmt->get_result()->fetch_assoc();
?>

<div class="container mt-4">
  <h3 class="text-primary fw-semibold"><i class="bi bi-pencil"></i> Editar Documento</h3>

  <form action="salvar_edicao.php" method="POST" enctype="multipart/form-data" class="mt-4">
    <input type="hidden" name="id" value="<?= $doc['id'] ?>">

    <div class="mb-3">
      <label class="form-label">Nome do Documento</label>
      <input type="text" name="nome" class="form-control" value="<?= $doc['nome'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Categoria</label>
      <select name="categoria" class="form-select" required>
        <option <?= ($doc['categoria'] == 'Manuais' ? 'selected' : '') ?>>Manuais</option>
        <option <?= ($doc['categoria'] == 'Relatórios' ? 'selected' : '') ?>>Relatórios</option>
        <option <?= ($doc['categoria'] == 'Procedimentos' ? 'selected' : '') ?>>Procedimentos</option>
        <option <?= ($doc['categoria'] == 'Planejamento' ? 'selected' : '') ?>>Planejamento</option>
        <option <?= ($doc['categoria'] == 'Termo de Empréstimo' ? 'selected' : '') ?>>Termo de Empréstimo</option>
        <option <?= ($doc['categoria'] == 'Termo de Saída' ? 'selected' : '') ?>>Termo de Saída</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Responsável</label>
      <input type="text" name="responsavel" class="form-control" value="<?= $doc['responsavel'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Arquivo Atual</label><br>
      <a href="<?= $doc['arquivo'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-eye"></i> Visualizar Arquivo Atual
      </a>
    </div>

    <div class="mb-3">
      <label class="form-label">Enviar novo arquivo (opcional)</label>
      <input type="file" name="arquivo" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
    </div>

    <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Salvar Alterações</button>
    <a href="documentos.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
