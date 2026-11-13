<?php use App\Core\Csrf; ?>
<h1 class="h4 mb-3">Nova movimentação</h1>
<div class="card" style="max-width:540px">
  <div class="card-body">
    <form method="post" action="<?= url('movements.store') ?>">
      <?= Csrf::field() ?>
      <div class="mb-3">
        <label class="form-label">Produto</label>
        <select name="produto_id" class="form-select" required>
          <option value="">Selecione...</option>
          <?php foreach($products as $p): ?>
          <option value="<?= (int)$p['id'] ?>" <?= $selectedId===(int)$p['id']?'selected':'' ?>>
            <?= e($p['nome']) ?> (saldo: <?= (int)$p['quantidade'] ?>)
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select" required>
          <option value="entrada" <?= $selectedType==='entrada'?'selected':'' ?>>Entrada</option>
          <option value="saida" <?= $selectedType==='saida'?'selected':'' ?>>Saída</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Quantidade</label>
        <input type="number" name="quantidade" min="1" step="1" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Observação (opcional)</label>
        <input type="text" name="observacao" maxlength="255" class="form-control">
      </div>
      <button class="btn btn-primary">Registrar</button>
      <a class="btn btn-link" href="<?= url('movements') ?>">Cancelar</a>
    </form>
  </div>
</div>