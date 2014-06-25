<?php

class Flash {
  protected $flashes = array();
  
  public function __construct() {
    $session                  = $_SESSION['MinicraftFlash'];
    $this->flashes['success'] = array();
    $this->flashes['info']    = array();
    $this->flashes['warning'] = array();
    $this->flashes['danger']  = array();
    
    if (!empty($session)) {
      foreach ($session as $key => $value) {
        if (!empty($value)) {
          foreach ($value as $message) {
            array_push($this->flashes[$key], $message);
          }
        }
      }
    }
    
    $_SESSION['MinicraftFlash']['success'] = array();
    $_SESSION['MinicraftFlash']['info']    = array();
    $_SESSION['MinicraftFlash']['warning'] = array();
    $_SESSION['MinicraftFlash']['danger']  = array();
  }
  
  public function getFlashes() {
    return $this->flashes;
  }
  
  public function getSuccessFlashes() {
    return $this->flashes['success'];
  }
  
  public function getInfoFlashes() {
    return $this->flashes['info'];
  }
  
  public function getWarningFlashes() {
    return $this->flashes['warning'];
  }
  
  public function getDangerFlashes() {
    return $this->flashes['danger'];
  }
  
  public function addFlash($message, $type = 'warning') {
    array_push($_SESSION['MinicraftFlash'][$type], $message);
    array_push($this->flashes[$type], $message);
  }
}
