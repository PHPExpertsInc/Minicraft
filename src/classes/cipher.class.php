<?php

class Cipher {
  protected $key;
  
  function __construct($key) {
    $this->key = hash('sha256', $key, true);
  }
  
  function encrypt($str) {
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, json_encode($str), MCRYPT_MODE_ECB));
  }
  
  function decrypt($str) {
    return json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, base64_decode($str), MCRYPT_MODE_ECB)));
  }
}
