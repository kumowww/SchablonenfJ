<?php

//check CLI
function isCLI()
{
    return PHP_SAPI === 'cli' || defined('STDIN');
}