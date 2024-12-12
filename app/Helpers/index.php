<?php

if (! function_exists('generate_banking_number')) {
    function generate_banking_number(): string
    {
        return str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }
}
