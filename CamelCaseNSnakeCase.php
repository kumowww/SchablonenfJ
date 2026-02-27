<?php

//Convert a snake case string to camel case string
function toCamelCase($value)
{
    $value = str_replace(['-', '_'], ' ', $value);
    $value = ucwords($value);
    $value =  str_replace(' ', '', $value);

    return lcfirst($value);
}

//Convert a camel case string to a snake case string
function toSnakeCase($value, $delimiter = '_')
{
    // Füge das Trennzeichen vor einem Großbuchstaben ein.
    $value = preg_replace('/(.)(?=[A-Z])/', '$1' . $delimiter, $value);

    return mb_strtolower($value);
}