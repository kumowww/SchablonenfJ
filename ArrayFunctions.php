<?php
/**
 * [EN] Helper functions for advanced array manipulation
 * Group an array of objects or associative arrays by a specific key
 * [DE] Hilfsfunktionen für fortgeschrittene Array-Manipulation
 * Gruppiert ein Array von Objekten oder assoziativen Arrays nach einem bestimmten Schlüssel
 */
function array_group_by(array $array, $key) {
    $result = [];
    foreach ($array as $item) {
        $val = is_object($item) ? $item->{$key} : $item[$key];
        $result[$val][] = $item;
    }
    return $result;
}
function array_get_dotted(array $array, string $path, $default = null) {
    foreach (explode('.', $path) as $segment) {
        if (!is_array($array) || !array_key_exists($segment, $array)) {
            return $default;
        }
        $array = $array[$segment];
    }
    return $array;
/**
 * [EN] Get a value from a multidimensional array using "dot notation" (e.g. 'user.profile.id')
 * [DE] Wert aus einem mehrdimensionalen Array mittels "Punkt-Notation" abrufen (z.B. 'user.profile.id') so wie so...
 */
}