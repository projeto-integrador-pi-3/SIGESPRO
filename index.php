<?php

require_once 'login/verifica_login.php';
include 'config.php';
include 'header.php';
?>

<h1 class="text-center mb-4">Portal de Gestão de Sistemas e Procedimentos de COTI</h1>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Sistemas</h5>
                <p class="card-text">Visualize e edite informações sobre os sistemas que utilizamos.</p>
                <a href="<?= BASE_URL ?>/sistemas/sistemas.php" class="btn btn-info w-100">Acessar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Procedimentos</h5>
                <p class="card-text">Documente os procedimentos técnicos e operacionais.</p>
                <a href="<?= BASE_URL ?>/procedimentos/procedimentos.php" class="btn btn-info w-100">Acessar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Documentos</h5>
                <p class="card-text">Centralize termos de responsabilidade e outros arquivos importantes.</p>
                <a href="<?= BASE_URL ?>/documentos/documentos.php" class="btn btn-info w-100">Acessar</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Subprefeituras</h5>
                <p class="card-text">Entre em contato com os responsáveis das unidades de TI e de CPDU.</p>
                <a href="<?= BASE_URL ?>/subprefeituras/subprefeituras.php" class="btn btn-info w-100">Acessar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Secretarias</h5>
                <p class="card-text">Entre em contato com os responsáveis das unidades de TI.</p>
                <a href="<?= BASE_URL ?>/secretarias/secretarias.php" class="btn btn-info w-100">Acessar</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>