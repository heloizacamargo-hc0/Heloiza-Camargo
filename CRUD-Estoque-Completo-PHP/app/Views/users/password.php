<?php use App\Core\Csrf; ?>
<h1 class="h4 mb-3">Alterar senha</h1>
<div class="card" style="max-width:440px">
  <div class="card-body">
    <form method="post" action="<?= url('password.update') ?>">
      <?= Csrf::field() ?>
      <div class="mb-3"><label class="form-label">Senha atual</label><input type="password" name="atual" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Nova senha (mínimo 8 caracteres)</label><input type="password" name="nova" minlength="8" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Confirmar nova senha</label><input type="password" name="confirmacao" minlength="8" class="form-control" required></div>
      <button class="btn btn-primary">Atualizar senha</button>
    </form>
  </div>
</div>