<?php use App\Core\Csrf; ?>
<div class="row justify-content-center pt-5">
  <div class="col-md-5 col-lg-4">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3">Controle de Estoque</h1>
        <form method="post" action="<?= url('login.post') ?>">
          <?= Csrf::field() ?>
          <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</div>