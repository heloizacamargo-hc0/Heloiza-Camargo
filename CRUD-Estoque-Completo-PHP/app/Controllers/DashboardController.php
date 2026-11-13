<?php
namespace App\Controllers;
use App\Core\{Auth,View};
use App\Models\{Movement,Product};

final class DashboardController {
    public function index():void {
        $user=Auth::requireLogin();
        View::render('dashboard/index',[
            'title'=>'Painel','user'=>$user,
            'stats'=>(new Product())->stats(),
            'recent'=>(new Movement())->recent(8)
        ]);
    }
}