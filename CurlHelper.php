<?php
/**
 * [EN] Simple wrapper for executing GET and POST requests via cURL
 * [DE] Einfacher Wrapper zur Ausführung von GET- und POST-Anfragen über cURL
 */

function send_request(string $url, string $method = 'GET', array $data = [], array $headers = []) {
    $ch = curl_init();

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    } elseif ($method === 'GET' && !empty($data)) {
        $url .= '?' . http_build_query($data);
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    // [EN] Return error message if request fails, otherwise decoded JSON
    // [DE] Fehlermeldung zurückgeben, wenn die Anfrage fehlschlägt, andernfalls dekodiertes JSON
    return $error ? "Error: $error" : json_decode($response, true);
}