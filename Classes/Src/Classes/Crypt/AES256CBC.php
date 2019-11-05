<?php

declare(strict_types = 1);

namespace Xanax\Classes;

class AES256CBC {
	
	const METHOD = 'AES-256-CBC';
    
    public function Encrypt( $string, $key ) {
        if (mb_strlen( $key, '8bit' ) !== 32) {
            throw new Exception( "Needs a 256-bit key!" );
        }
		
        $ivsize = openssl_cipher_iv_length( self::METHOD );
        $iv = openssl_random_pseudo_bytes( $ivsize );
        
        $ciphertext = openssl_encrypt(
            $string,
            string::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        
        return base64_encode( $iv . $ciphertext );
    }

    public function Decrypt($string, $key) {
		$string = base64_decode($string);
		
        if (mb_strlen( $key, '8bit' ) !== 32) {
            throw new Exception( "Needs a 256-bit key!" );
        }
		
        $ivsize = openssl_cipher_iv_length(self::METHOD);
        $iv = mb_substr($string, 0, $ivsize, '8bit');
        $ciphertext = mb_substr($string, $ivsize, null, '8bit');
        
        return openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }
	
}