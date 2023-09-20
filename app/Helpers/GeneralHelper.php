<?php

namespace App\Helpers;

class GeneralHelper
{

    public static function decrypt(string $ivHashCiphertext, string $password):string
    {
        // we receive the encrypted string from the post
        return trim(openssl_decrypt($ivHashCiphertext, 'AES-128-CBC', hex2bin(substr($password, 0, 32)), OPENSSL_ZERO_PADDING, hex2bin(substr($password, 32))));
    }

    public static function getEncyrptionKeyIV():string {
        return bin2hex(random_bytes(32));
    }
}
