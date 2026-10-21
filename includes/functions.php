<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_expires']) || $_SESSION['csrf_expires'] < time()) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_expires'] = time() + 3600;
    }
    return (string)$_SESSION['csrf_token'];
}

function csrf_verify(?string $token): bool
{
    return $token !== null && !empty($_SESSION['csrf_token']) && !empty($_SESSION['csrf_expires'])
        && $_SESSION['csrf_expires'] >= time() && hash_equals((string)$_SESSION['csrf_token'], $token);
}

function flash(string $key, mixed $value = null): mixed
{
    if (func_num_args() > 1) { $_SESSION['_flash'][$key] = $value; return null; }
    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $value;
}

function contact_rate_limited(PDO $pdo, string $ip): bool
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM contact_messages WHERE ip_address = :ip AND created_at >= DATE_SUB(NOW(), INTERVAL 10 MINUTE)');
    $stmt->execute(['ip' => $ip]);
    return (int)$stmt->fetchColumn() >= 3;
}
