<?php

namespace App\Crypto;

/**
* Crypto
* requires php-scrypt
* rewrite this part using php-libsodium after PHP 7.2 stables
* params must been pre-decoded.
*/
class Crypto
{
	const ENCRYPT_METHOD = 'AES-256-CTR';
	const HASH_ALGO = 'sha256';
	const KEY_LENGTH = 48;
	/**
	 * ----------------
	 *    Key Composition	|
	 * ---------------	|
	 * KEY_ENC |  KEY_MAC	|
	 *    32.   |     16.	|
	 * ----------------
	*/

	/**
	 * Encrypt incoming message; 
	 * MAC-then-Encrypt enables both auth and password verification.
	 * 	I consider this secure enough for Flute's threat model. --polymolt.
	 * 
	 * @param string $plaintext 
	 * @param string $passphrase 
	 * @return array
	 */
	public static function encrypt($plaintext, $passphrase)
	{
		//prep for encryption
		$salt = random_bytes(8);
		$key = self::keyGen($passphrase, $salt);
		$iv = random_bytes((openssl_cipher_iv_length(self::ENCRYPT_METHOD)));
		$mac = hash_hmac(self::HASH_ALGO, $plaintext, substr($key, 32), true);

		//encryption
		$ciphertext = openssl_encrypt($mac.$plaintext, self::ENCRYPT_METHOD, substr($key, 0, 32), OPENSSL_ZERO_PADDING, $iv);

		//erase critical data ASAP
		$passphrase = null;
		$key = null;
		$plaintext = null;
		$mac = null;

		//return ciphertext, salt and iv in PHP string
		return array(
			'ciphertext' => $ciphertext, 
			'iv' => $iv,
			'salt' => $salt,
			);
	}

	/**
	 * Decrypt incoming message id
	 * 
	 * @param type $ciphertext 
	 * @param type $passphrase 
	 * @param type $iv 
	 * @param type $salt 
	 * @return string or False if failed.
	 */
	public static function decrypt($ciphertext, $passphrase, $iv, $salt)
	{
		//prep for decryption
		$key = self::keyGen($passphrase, $salt);
		$passphrase = null;

		//decryption
		$buffer = openssl_decrypt($ciphertext, self::ENCRYPT_METHOD, substr($key, 0, 32), OPENSSL_ZERO_PADDING, $iv);
		$mac_provided = substr($buffer, 0, 32);
		$plaintext = substr($buffer, 32);

		//HMAC auth
		$mac_calculated = hash_hmac(self::HASH_ALGO, $plaintext, substr($key, 32), true);
		if (!hash_equals($mac_calculated, $mac_provided)) {
			$plaintext = false;
		}

		//erase critical data ASAP
		$key = null;
		$buffer = null;

		return $plaintext;
	}

	/**
	 * Derive encryption key using php-scrypt
	 * 
	 * @param string $passphrase 
	 * @param string $salt 
	 * @return string
	 */
	private static function keyGen($passphrase, $salt)
	{
		// scrypt params.
		$_N = 16384; // The CPU difficultly (must be a power of 2, > 1)
		$_r = 8; // The memory difficulty
		$_p = 2; // The parallel difficulty		

		return scrypt($passphrase, $salt, $_N, $_r, $_p, self::KEY_LENGTH);
	}
}