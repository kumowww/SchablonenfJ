<?php
/**
 * [EN] Utility functions for security and data sanitization
 * Clean string from dangerous HTML tags (XSS protection)
 * [DE] Hilfsfunktionen für Sicherheit und Datenbereinigung
 * Bereinigt Strings von gefährlichen HTML-Tags (XSS--Schutz)
 */
function clean_input(string $data): string {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * [EN] Generate a cryptographically secure CSRF token
 * [DE] Erzeugt ein kryptografisch sicheres CSRF-Token
 */
function generate_token(int $length = 32): string {
    return bin2hex(random_bytes($length / 2));
}

/**
 * [EN] Check password complexity (min 8 chars, must include letter and number)
 * [DE] Passwortkomplexität prüfen (min 8 Zeichen, muss Buchstabe und Zahl enthalten)
 */
function is_password_strong(string $password): bool {
    return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
}