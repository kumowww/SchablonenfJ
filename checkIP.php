<?php
function isIP($ip, $type = FILTER_FLAG_IPV4, $exludePrivAndRes = false)
{
    // Check if the value is falsy
    if (empty($ip)) {
        return false;
    }

    $type = strtolower($type);

    switch ($type) {
        case 'ipv4':
            $type = FILTER_FLAG_IPV4;
            break;

        case 'ipv6':
            $type = FILTER_FLAG_IPV6;
            break;

        default:
            $type = FILTER_FLAG_IPV4;
            break;
    }

    // Prüfen, ob der Standardwert ein boolescher Wert ist
    is_bool($exludePrivAndRes) || $exludePrivAndRes = false;

    if ($exludePrivAndRes) {
        // Verwenden Sie bitweises ODER, wenn die privaten und reservierten Adressbereiche ausgeschlossen werden
        $type |= FILTER_FLAG_NO_PRIV_RANGE;
        $type |= FILTER_FLAG_NO_RES_RANGE;
    }

    return (bool) filter_var($ip, FILTER_VALIDATE_IP, $type);
}