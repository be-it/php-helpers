<?php
/**
 * @link -
 * @copyright Copyright (c) 2017 Triawarman
 * @license MIT
 * @author Triawarman <3awarman@gmail.com>
 */
namespace BeIt\PhpHelpers;

/* 
 * Modified from
 * https://naveensnayak.wordpress.com/2013/03/12/simple-php-encrypt-and-decrypt/
 */
class Crypt
{
    const ENCRYPT_METHODE = "AES-256-CBC";
    //const SECRET_KEY = '1';
    //const SECRET_IV = '1';

    public static function encrypt($value, $secretKey = 'this is secret key', $secretIv = 'this is secret iv')
    {        
        //Hash
        $key = hash('sha256', $secretKey);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secretIv), 0, 16);
        
        $output = openssl_encrypt($value, self::ENCRYPT_METHODE, $key, 0, $iv);
        $output = base64_encode($output);
        
        return $output;
    }
    
    public static function decrypt($value)
    {        
        //Hash
        $key = hash('sha256', $secretKey);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secretIv), 0, 16);
        
        $output = openssl_decrypt(base64_decode($value), self::ENCRYPT_METHODE, $key, 0, $iv);   
        return $output;
    }
}
