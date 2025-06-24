<?php

class Session {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            $this->startSecureSession();
        }
        
        if (!isset($_SESSION['_flash'])) {
            $_SESSION['_flash'] = [];
        }
    }
    
    private function startSecureSession(): void {
        ini_set('session.cookie_httponly', 1);
        //ini_set('session.cookie_secure', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_samesite', 'Strict');
        
        session_start();
        
        if (!isset($_SESSION['_created'])) {
            $_SESSION['_created'] = time();
        } elseif (time() - $_SESSION['_created'] > 1800) {
            session_regenerate_id(true);
            $_SESSION['_created'] = time();
        }
    }
    
    public function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }
    
    public function get(string $key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public function has(string $key): bool {
        return isset($_SESSION[$key]);
    }
    
    public function remove(string $key): void {
        unset($_SESSION[$key]);
    }
    
    public function clear(): void {
        session_unset();
    }
    
    public function destroy(): void {
        session_destroy();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }
    
    public function flash(string $type, string $message): void {
        if (!isset($_SESSION['_flash'][$type])) {
            $_SESSION['_flash'][$type] = [];
        }
        $_SESSION['_flash'][$type][] = $message;
    }
    
    public function flashSuccess(string $message): void {
        $this->flash('success', $message);
    }
    
    public function flashError(string $message): void {
        $this->flash('error', $message);
    }
    
    public function flashWarning(string $message): void {
        $this->flash('warning', $message);
    }
    
    public function flashInfo(string $message): void {
        $this->flash('info', $message);
    }
    
    public function getFlash(string $type): array {
        $messages = $_SESSION['_flash'][$type] ?? [];
        unset($_SESSION['_flash'][$type]);
        return $messages;
    }
    
    public function getAllFlash(): array {
        $messages = $_SESSION['_flash'] ?? [];
        $_SESSION['_flash'] = [];
        return $messages;
    }
    
    public function hasFlash(string $type): bool {
        return !empty($_SESSION['_flash'][$type]);
    }
    
    public function generateCsrfToken(): string {
        $token = bin2hex(random_bytes(32));
        $_SESSION['_csrf_token'] = $token;
        return $token;
    }
    
    public function getCsrfToken(): string {
        if (!isset($_SESSION['_csrf_token'])) {
            return $this->generateCsrfToken();
        }
        return $_SESSION['_csrf_token'];
    }
    
    public function verifyCsrfToken(string $token): bool {
        return isset($_SESSION['_csrf_token']) && hash_equals($_SESSION['_csrf_token'], $token);
    }
}