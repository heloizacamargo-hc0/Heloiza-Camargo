<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

function url(string $route = '', array $params = []): string {
    $query = $route !== '' ? array_merge(['r' => $route], $params) : $params;
    return 'index.php' . ($query ? '?' . http_build_query($query) : '');
}

function redirect(string $route, array $params = []): never {
    header('Location: ' . url($route, $params));
    exit;
}

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function positiveId(mixed $value): int {
    $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? 0 : $id;
}

function setFlash(string $type, string $message): void {
    $_SESSION['_flash'] = ['type' => $type, 'message' => $message];
}

function takeFlash(): ?array {
    $flash = $_SESSION['_flash'] ?? null;
    unset($_SESSION['_flash']);
    return $flash;
}