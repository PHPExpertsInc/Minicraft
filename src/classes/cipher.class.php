<?php

class Cipher {  
  public function __construct($key) {
    $this->key = $key;
  }
  
  public function encrypt($input) {
    $size  = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
    $input = self::pkcs5_pad($input, $size);
    $td    = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
    $iv    = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $this->key, $iv);
    $data = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $data = base64_encode($data);
    
    return $data;
  }
  
  private static function pkcs5_pad($text, $blocksize) {
    $pad = $blocksize - (strlen($text) % $blocksize);
    
    return $text . str_repeat(chr($pad), $pad);
  }
  
  public static function decrypt($sStr) {
    $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, base64_decode($sStr), MCRYPT_MODE_ECB);
    $dec_s     = strlen($decrypted);
    $padding   = ord($decrypted[$dec_s - 1]);
    $decrypted = substr($decrypted, 0, -$padding);
    
    return $decrypted;
  }
  
  /*
  // Old method which is not compatible with Java
  
  protected $key;
  
  public function encrypt($str) {
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, json_encode($str), MCRYPT_MODE_ECB));
  }
  
  public function decrypt($str) {
    return json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, base64_decode($str), MCRYPT_MODE_ECB)));
  }
  */
}