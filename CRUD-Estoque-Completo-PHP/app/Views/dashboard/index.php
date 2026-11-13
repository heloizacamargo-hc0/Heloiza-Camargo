<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 m-0">Painel</h1>
  <a class="btn btn-primary btn-sm" href="<?= url('movements.create') ?>">+ Nova movimentação</a>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3"><div class="card"><div class="card-body"><div class="text-muted small">Produtos</div><div class="fs-4 fw-bold"><?= (int)$stats['total_produtos'] ?></div></div></div></div>
  <div class="col-6 col-lg-3"><div class="card"><div class="card-body"><div class="text-muted small">Unidades em estoque</div><div class="fs-4 fw-bold"><?= (int)$stats['unidades'] ?></div></div></div></div>
  <div class="col-6 col-lg-3"><div class="card"><div class="card-body"><div class="text-muted small">Valor total</div><div class="fs-4 fw-bold">R$ <?= number_format((float)$stats['valor'],2,',','.') ?></div></div></div></div>
  <div class="col-6 col-lg-3"><div class="card"><div class="card-body"><div class="text-muted small">Estoque baixo (&le; 5)</div><div class="fs-4 fw-bold text-danger"><?= (int)$stats['baixos'] ?></div></div></div></div>
</div>

<div class="card">
  <div class="card-header bg-white fw-semibold">Últimas movimentações</div>
  <div class="table-responsive">
    <table class="table table-sm table-hover mb-0">
      <thead><tr><th>Data</th><th>Produto</th><th>Tipo</th><th>Qtd</th><th>Responsável</th><th>Obs.</th></tr></thead>
      <tbody>
      <?php if(!$recent): ?>
        <tr><td colspan="6" class="text-center text-muted py-3">Nenhuma movimentação registrada.</td></tr>
      <?php else: foreach($recent as $m): ?>
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