<?php
use App\Core\Csrf;
$flash=takeFlash();
$route=$_GET['r']??'';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= e($title ?? 'Controle de Estoque') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php if(!empty($user)): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="<?= url('dashboard') ?>">Estoque</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link <?= $route==='dashboard'?'active':'' ?>" href="<?= url('dashboard') ?>">Painel</a></li>
        <li class="nav-item"><a class="nav-link <?= str_starts_with($route,'products')?'active':'' ?>" href="<?= url('products') ?>">Produtos</a></li>
        <li class="nav-item"><a class="nav-link <?= str_starts_with($route,'movements')?'active':'' ?>" href="<?= url('movements') ?>">Movimentações</a></li>
        <?php if($user['perfil']==='admin'): ?>
        <li class="nav-item"><a class="nav-link <?= $route==='users'?'active':'' ?>" href="<?= url('users') ?>">Usuários</a></li>
        <?php endif; ?>
      </ul>
      <div class="d-flex align-items-center gap-2 text-light small">
        <span><?= e($user['nome']) ?> (<?= e($user['perfil']) ?>)</span>
        <a class="btn btn-outline-light btn-sm" href="<?= url('password') ?>">Senha</a>
        <form method="post" action="<?= url('logout') ?>" class="m-0">
          <?= Csrf::field() ?>
          <button class="btn btn-danger btn-sm">Sair</button>
        </form>
      </div>
    </div>
  </div>
</nav>
<?php endif; ?>
<main class="container pb-5">
<?php if($flash): ?>
  <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>