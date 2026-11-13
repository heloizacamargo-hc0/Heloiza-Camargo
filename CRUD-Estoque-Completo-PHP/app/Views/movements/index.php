<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h1 class="h4 m-0">Movimentações</h1>
  <a class="btn btn-primary btn-sm" href="<?= url('movements.create') ?>">+ Nova movimentação</a>
</div>

<div class="btn-group btn-group-sm mb-3">
  <a class="btn btn-outline-secondary <?= $tipo===''?'active':'' ?>" href="<?= url('movements') ?>">Todas</a>
  <a class="btn btn-outline-secondary <?= $tipo==='entrada'?'active':'' ?>" href="<?= url('movements',['tipo'=>'entrada']) ?>">Entradas</a>
  <a class="btn btn-outline-secondary <?= $tipo==='saida'?'active':'' ?>" href="<?= url('movements',['tipo'=>'saida']) ?>">Saídas</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Data</th><th>Produto</th><th>Tipo</th><th>Qtd</th><th>Responsável</th><th>Observação</th></tr></thead>
      <tbody>
      <?php if(!$items): ?>
        <tr><td colspan="6" class="text-center text-muted py-3">Nenhuma movimentação encontrada.</td></tr>
      <?php else: foreach($items as $m): ?>
        <tr>
          <td><?= e($m['criado_em']) ?></td>
          <td><?= e($m['produto']) ?></td>
          <td><span class="badge bg-<?= $m['tipo']==='entrada'?'success':'warning text-dark' ?>"><?= e($m['tipo']) ?></span></td>
          <td><?= (int)$m['quantidade'] ?></td>
          <td><?= e($m['responsavel']) ?></td>
          <td><?= e($m['observacao']) ?></td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>