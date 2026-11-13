<?php
declare(strict_types=1);
namespace App\Core;

final class Csrf {
    public static function token(): string {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    public static function field(): string {
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function verify(?string $token = null): void {
        $submitted = $token ?? ($_POST['_csrf'] ?? null);
        if (!is_string($submitted) || empty($_SESSION['_csrf']) || !hash_equals($_SESSION['_csrf'], $submitted)) {
            http_response_code(419);
            exit('Token CSRF inválido ou expirado.');
        }
    }

    public static function check(?string $token = null): void {
        self::verify($token);
    }
}