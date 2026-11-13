<?php use App\Core\Csrf; $editing=$item!==null; ?>
<h1 class="h4 mb-3"><?= $editing?'Editar produto':'Novo produto' ?></h1>
<div class="card" style="max-width:540px">
  <div class="card-body">
    <form method="post" action="<?= url($editing?'products.update':'products.store') ?>">
      <?= Csrf::field() ?>
      <?php if($editing): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" maxlength="120" value="<?= e($item['nome']??'') ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Categoria</label>
        <input type="text" name="categoria" maxlength="80" value="<?= e($item['categoria']??'') ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Preço (R$)</label>
        <input type="text" name="preco" value="<?= e($item['preco']??'') ?>" placeholder="0.00" class="form-control" required>
      </div>
      <?php if($editing): ?>
      <div class="alert alert-info py-2 small">Quantidade atual: <strong><?= (int)$item['quantidade'] ?></strong>. Altere o saldo pela tela de Movimentações.</div>
      <?php endif; ?>
      <button class="btn btn-primary">Salvar</button>
      <a class="btn btn-link" href="<?= url('products') ?>">Cancelar</a>
    </form>
  </div>
</div>