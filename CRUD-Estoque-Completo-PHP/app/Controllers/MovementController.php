<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\{Auth, Csrf, View};
use App\Models\{Movement, Product};

final class MovementController {
    public function index(): void {
        Auth::requireLogin();
        $tipo = (string)($_GET['tipo'] ?? '');
        View::render('movements/index', [
            'title' => 'Movimentações',
            'user' => Auth::user(),
            'items' => (new Movement())->recent(100, $tipo),
            'tipo' => $tipo,
        ]);
    }

    public function create(): void {
        Auth::requireLogin();
        View::render('movements/form', [
            'title' => 'Nova Movimentação',
            'user' => Auth::user(),
            'products' => (new Product())->all(''),
            'selectedId' => positiveId($_GET['produto_id'] ?? 0),
            'selectedType' => (string)($_GET['tipo'] ?? 'entrada'),
        ]);
    }

    public function store(): void {
        Auth::requireLogin();
        Csrf::verify();

        $produtoId = (int)($_POST['produto_id'] ?? 0);
        $tipo = (string)($_POST['tipo'] ?? '');
        $quantidade = (int)($_POST['quantidade'] ?? 0);
        $observacao = trim((string)($_POST['observacao'] ?? ''));

        if ($produtoId <= 0 || !in_array($tipo, ['entrada', 'saida'], true) || $quantidade <= 0) {
            setFlash('danger', 'Dados inválidos para a movimentação.');
            redirect('movements.create');
        }

        try {
            (new Movement())->record($produtoId, (int)Auth::user()['id'], $tipo, $quantidade, $observacao);
            setFlash('success', 'Movimentação registrada com sucesso.');
            redirect('movements');
        } catch (\Throwable $e) {
            setFlash('danger', $e->getMessage());
            redirect('movements.create');
        }
    }
}