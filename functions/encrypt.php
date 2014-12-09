<?php
/*
 * PHP mcrypt - Basic encryption and decryption of a string
 */

function encrypt_string($text, $key) {
    /*
	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
	return mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $text, MCRYPT_MODE_CBC, $iv);
    */
    return base64_encode($text);
}

function decrypt_string($cipher, $key, $iv) {
	// return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cipher, MCRYPT_MODE_CBC, $iv);
    return base64_decode($cipher);
}

?>