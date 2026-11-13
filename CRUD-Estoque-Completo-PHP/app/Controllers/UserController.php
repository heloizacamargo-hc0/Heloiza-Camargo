<?php
namespace App\Controllers;
use App\Core\{Auth,Csrf,View};
use App\Models\User;
use Throwable;

final class UserController {
    public function index():void {
        $admin=Auth::requireAdmin();
        View::render('users/index',['title'=>'Usuários','user'=>$admin,'items'=>(new User())->all()]);
    }
    public function store():void {
        Auth::requireAdmin();Csrf::verify();
        $nome=trim((string)($_POST['nome']??''));
        $email=mb_strtolower(trim((string)($_POST['email']??'')));
        $senha=(string)($_POST['senha']??'');
        $perfil=(string)($_POST['perfil']??'operador');
        if($nome==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($senha)<8 || !in_array($perfil,['admin','operador'],true)){
            flash('danger','Dados inválidos. Use e-mail válido e senha com 8+ caracteres.');go('users');
        }
        try {
            (new User())->create($nome,$email,$senha,$perfil);
            flash('success','Usuário criado.');
        } catch(Throwable) {
            flash('danger','Não foi possível criar (e-mail pode já estar em uso).');
        }
        go('users');
    }
    public function toggle():void {
        $admin=Auth::requireAdmin();Csrf::verify();
        $id=positiveId($_POST['id']??null);
        if(!$id || $id===(int)$admin['id']){flash('warning','Você não pode desativar a própria conta.');go('users');}
        (new User())->toggle($id);
        flash('success','Status alterado.');go('users');
    }
    public function passwordForm():void {
        $user=Auth::requireLogin();
        View::render('users/password',['title'=>'Alterar senha','user'=>$user]);
    }
    public function passwordUpdate():void {
        $user=Auth::requireLogin();Csrf::verify();
        $atual=(string)($_POST['atual']??'');
        $nova=(string)($_POST['nova']??'');
        $conf=(string)($_POST['confirmacao']??'');
        if(!password_verify($atual,$user['senha_hash'])){flash('danger','Senha atual incorreta.');go('password');}
        if(strlen($nova)<8 || $nova!==$conf){flash('danger','Nova senha precisa ter 8+ caracteres e coincidir com a confirmação.');go('password');}
        (new User())->changePassword((int)$user['id'],$nova);
        flash('success','Senha atualizada com sucesso.');go('dashboard');
    }
}