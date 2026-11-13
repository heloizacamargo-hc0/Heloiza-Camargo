<?php
namespace App\Controllers;
use App\Core\{Auth,Csrf,View};
use App\Models\Product;
use Throwable;

final class ProductController {
    public function index():void {
        $user=Auth::requireLogin();
        $search=trim((string)($_GET['q']??''));
        View::render('products/index',[
            'title'=>'Produtos','user'=>$user,
            'items'=>(new Product())->all($search),'search'=>$search
        ]);
    }
    public function create():void {
        $user=Auth::requireLogin();
        View::render('products/form',['title'=>'Novo produto','user'=>$user,'item'=>null]);
    }
    public function store():void {
        Auth::requireLogin();Csrf::verify();
        $d=$this->validate();
        if(!$d){flash('danger','Dados inválidos. Verifique nome, categoria e preço.');go('products.create');}
        (new Product())->create(...$d);
        flash('success','Produto cadastrado com estoque 0. Registre uma entrada para adicionar unidades.');
        go('products');
    }
    public function edit():void {
        $user=Auth::requireLogin();
        $id=positiveId($_GET['id']??null);$item=$id?(new Product())->find($id):null;
        if(!$item){flash('danger','Produto não encontrado.');go('products');}
        View::render('products/form',['title'=>'Editar produto','user'=>$user,'item'=>$item]);
    }
    public function update():void {
        Auth::requireLogin();Csrf::verify();
        $id=positiveId($_POST['id']??null);$d=$this->validate();
        if(!$id || !$d){flash('danger','Dados inválidos.');go('products');}
        (new Product())->update($id,...$d);
        flash('success','Produto atualizado.');go('products');
    }
    public function delete():void {
        Auth::requireLogin();Csrf::verify();
        $id=positiveId($_POST['id']??null);
        if(!$id){flash('danger','Produto inválido.');go('products');}
        try {
            if((new Product())->delete($id))flash('success','Produto excluído.');
            else flash('warning','Só é possível excluir produtos com estoque zerado e sem movimentações.');
        } catch(Throwable) {
            flash('warning','Produto possui histórico de movimentações e não pode ser excluído.');
        }
        go('products');
    }
    private function validate():?array {
        $nome=trim((string)($_POST['nome']??''));
        $cat=trim((string)($_POST['categoria']??''));
        $preco=money((string)($_POST['preco']??''));
        if($nome==='' || mb_strlen($nome)>120 || $cat==='' || mb_strlen($cat)>80 || $preco===null)return null;
        return [$nome,$cat,$preco];
    }
}