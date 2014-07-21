<?php

/**
 * ##########################################
 * # _______  _                     __  _   #
 * #|__   __|(_)                   / _|| |  #
 * #   | |    _   ___  _ __  __ _ | |_ | |_ #
 * #   | |   | | / __|| '__|/ _` ||  _|| __|#
 * #   | |   | || (__ | |  | (_| || |  | |_ #
 * #   |_|   |_| \___||_|   \____||_|   \__|#
 * #                                        #
 * ##########################################
 *
 * ==============================
 * @author Charles Tatibouët http://charlestati.com
 * @author Olivier Villeneuve
 * @link http://ticraft.fr
 * ==============================
 */

class Ticraft {
  protected $username;
  protected $api_key;
  protected $api_url = 'http://api.ticraft.fr/index.php';
  
  public function __construct() {
    $data = Database::getApiInfos();
    $this->username = $data['username'];
    $this->api_key  = $data['api_key'];
  }
  
  public function call($method, $args = array()) {
    $arguments = array(
      'method' => $method,
      'arguments' => $args
    );
    
    $cipher      = new Cipher($this->api_key);
    $enc_request = $cipher->encrypt($arguments);
    
    $params             = array();
    $params['request']  = $enc_request;
    $params['username'] = $this->username;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, count($params));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $result = curl_exec($ch);
    curl_close($ch);
    
    $json   = @json_decode($result, true);
    $return = (array) $json;
    
    //echo($method . ': ' . Helpers::var_dump($result));
    
    if (isset($return['status']) and $return['status'] == 0) {
      return !empty($return['data']) ? $return['data'] : null;
    } elseif (isset($return['status']) and $return['status'] == 901) {
      Logger::log('Method ' . $method . ' is unknown', 1);
    } else {
      if (isset($return['status']) and isset($return['message'])) {
        Logger::log('Error ' . $return['status'] . ': ' . $return['message'], 1);
      }
    }
  }
}