<?php use App\Core\Csrf; ?>
<h1 class="h4 mb-3">Usuários</h1>

<div class="card mb-4">
  <div class="card-header bg-white fw-semibold">Novo usuário</div>
  <div class="card-body">
    <form method="post" action="<?= url('users.store') ?>" class="row g-2">
      <?= Csrf::field() ?>
      <div class="col-md-3"><input type="text" name="nome" placeholder="Nome" class="form-control form-control-sm" required></div>
      <div class="col-md-3"><input type="email" name="email" placeholder="E-mail" class="form-control form-control-sm" required></div>
      <div class="col-md-2"><input type="password" name="senha" minlength="8" placeholder="Senha (8+)" class="form-control form-control-sm" required></div>
      <div class="col-md-2">
        <select name="perfil" class="form-select form-select-sm">
          <option value="operador">Operador</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="col-md-2"><button class="btn btn-primary btn-sm w-100">Criar</button></div>
    </form>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead><tr><th>Nome</th><th>E-mail</th><th>Perfil</th><th>Status</th><th class="text-end">Ação</th></tr></thead>
      <tbody>
      <?php foreach($items as $u): ?>
        <tr>
          <td><?= e($u['nome']) ?></td>
          <td><?= e($u['email']) ?></td>
          <td><?= e($u['perfil']) ?></td>
          <td><span class="badge bg-<?= (int)$u['ativo']?'success':'secondary' ?>"><?= (int)$u['ativo']?'Ativo':'Inativo' ?></span></td>
          <td class="text-end">
            <?php if((int)$u['id']!==(int)$user['id']): ?>
            <form method="post" action="<?= url('users.toggle') ?>" class="d-inline">
              <?= Csrf::field() ?>
              <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
              <button class="btn btn-outline-secondary btn-sm"><?= (int)$u['ativo']?'Desativar':'Ativar' ?></button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>