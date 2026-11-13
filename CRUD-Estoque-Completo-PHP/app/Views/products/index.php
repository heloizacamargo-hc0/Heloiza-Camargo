<?php use App\Core\Csrf; ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h1 class="h4 m-0">Produtos</h1>
  <a class="btn btn-primary btn-sm" href="<?= url('products.create') ?>">+ Novo produto</a>
</div>

<form class="row g-2 mb-3" method="get" action="index.php">
  <input type="hidden" name="r" value="products">
  <div class="col-sm-6 col-md-4"><input type="text" name="q" value="<?= e($search) ?>" class="form-control form-control-sm" placeholder="Buscar por nome ou categoria"></div>
  <div class="col-auto"><button class="btn btn-outline-secondary btn-sm">Filtrar</button></div>
  <?php if($search!==''): ?><div class="col-auto"><a class="btn btn-link btn-sm" href="<?= url('products') ?>">Limpar</a></div><?php endif; ?>
</form>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>Nome</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th class="text-end">Ações</th></tr></thead>
      <tbody>
      <?php if(!$items): ?>
        <tr><td colspan="5" class="text-center text-muted py-3">Nenhum produto encontrado.</td></tr>
      <?php else: foreach($items as $p): ?>
        <tr>
          <td><?= e($p['nome']) ?></td>
          <td><?= e($p['categoria']) ?></td>
          <td>R$ <?= number_format((float)$p['preco'],2,',','.') ?></td>
          <td><span class="badge bg-<?= (int)$p['quantidade']<=5?'danger':'secondary' ?>"><?= (int)$p['quantidade'] ?></span></td>
          <td class="text-end">
            <a class="btn btn-outline-success btn-sm" href="<?= url('movements.create',['product_id'=>$p['id'],'tipo'=>'entrada']) ?>">Movimentar</a>
            <a class="btn btn-outline-primary btn-sm" href="<?= url('products.edit',['id'=>$p['id']]) ?>">Editar</a>
            <form method="post" action="<?= url('products.delete') ?>" class="d-inline" data-confirm="Excluir este produto?">
              <?= Csrf::field() ?>
              <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
              <button class="btn btn-outline-danger btn-sm">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>