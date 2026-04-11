<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



if (!defined('BASE_URL')) {
    include_once __DIR__ . '/config.php';
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGESPRO</title> <!--nome na aba-->


    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ícones Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS próprio -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css">

    <!-- CSS DataTables + Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script type="module" src="https://ajax.googleapis.com/ajax/libs/@googlemaps/extended-component-library/0.6.11/index.min.js">
    </script>

    <!-- jQuery (necessário para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- TinyMCE (para editor de texto) -->
    <script src="https://cdn.tiny.cloud/1/9gfl138va5t2x8j5218wvak2p0x7dn2x7xsxle7kzit3ximt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            tinymce.init({
                selector: '#descricao',
                height: 400,
                menubar: true,
                plugins: [
                    'advlist autolink lists link image charmap preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste help wordcount'
                ],
                toolbar: `undo redo | formatselect | 
              bold italic underline forecolor backcolor | 
              alignleft aligncenter alignright alignjustify | 
              bullist numlist outdent indent | 
              image link | removeformat | help`,
                automatic_uploads: true,
                paste_data_images: true,
                images_upload_url: BASE_URL + '/procedimentos/upload_imagem.php',
                file_picker_types: 'image',
                image_uploadtab: true,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
                branding: false,
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save();
                    });
                }
            });
        });
    </script>


    <!-- Variável BASE_URL para JS -->
    <script>
        const BASE_URL = "<?= BASE_URL ?>";
    </script>





</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASE_URL ?>/index.php">SIGESPRO COTI/SMSUB</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/sistemas/sistemas.php">Sistemas</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/procedimentos/procedimentos.php">Procedimentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/documentos/documentos.php">Documentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/subprefeituras/subprefeituras.php">Subprefeituras</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/secretarias/secretarias.php">Secretarias</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/usuarios.php">Usuários</a></li>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <!-- Usuário logado -->
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?= BASE_URL ?>/login/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Sair
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Usuário não logado -->
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/login/login_form.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mt-5">