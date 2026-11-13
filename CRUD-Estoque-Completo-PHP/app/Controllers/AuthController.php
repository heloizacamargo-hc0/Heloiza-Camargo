<?php
namespace App\Controllers;
use App\Core\{Auth,Csrf,View};
use App\Models\User;

final class AuthController {
    public function showLogin():void {
        if(Auth::user())go('dashboard');
        View::render('auth/login',['title'=>'Entrar']);
    }
    public function login():void {
        Csrf::verify();
        $email=mb_strtolower(trim((string)($_POST['email']??'')));
        $senha=(string)($_POST['senha']??'');
        $u=(new User())->byEmail($email);
        // Mesma mensagem para e-mail inexistente, senha errada ou conta inativa.
        if(!$u || !(int)$u['ativo'] || !password_verify($senha,$u['senha_hash'])){
            flash('danger','E-mail ou senha inválidos.');go('login');
        }
        Auth::login((int)$u['id']);
        go('dashboard');
    }
    public function logout():void {
        Csrf::verify();Auth::logout();go('login');
    }
}