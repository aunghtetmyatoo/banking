<?php

if (! function_exists('generate_banking_number')) {
    function generate_banking_number(): string
    {
        return str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('get_random_digit')) {
    function get_random_digit(
        int $length = 6,
    ): string {
        if ($length < 1) {
            throw new Exception('Length value cannot be less than one');
        }

        $max = '9';

        for ($i = 1; $i < $length; $i++) {
            $max .= '9';
        }

        return str_pad((string) mt_rand(0, (int) $max), $length, '0', STR_PAD_LEFT);
    }
}
