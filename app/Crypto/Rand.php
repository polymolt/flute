<?php

namespace App\Crypto;

/**
* Rand
* generates Flute-specific random data.
*/
class Rand
{
	/**
	 * Generate a password metrix.
	 */
	public static function metrix()
	{
		$passphrase_metrix = array();
        	for ($i = 1; $i <= 8; $i++) {
            		$bytes = openssl_random_pseudo_bytes(4);
            		$passphrase_1 = bin2hex($bytes);
            		$bytes = openssl_random_pseudo_bytes(4);
            		$passphrase_2 = bin2hex($bytes);
            		$bytes = openssl_random_pseudo_bytes(4);
            		$passphrase_3 = bin2hex($bytes);

            		$passphrase_grouped = strtoupper($passphrase_1 . ' ' . $passphrase_2 . ' ' . $passphrase_3);
            		array_push($passphrase_metrix, $passphrase_grouped);
        	}

        	$bytes = null;
        	$passphrase_1 = null;
        	$passphrase_2 = null;
        	$passphrase_3 = null;
        	$passphrase_grouped = null;

        	return $passphrase_metrix;
	}
}