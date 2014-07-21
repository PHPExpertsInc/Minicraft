<?php

class Store {
  
  protected $packs = array();
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        $this->addStorePack(new StorePack($value));
      }
    } else {
      Logger::log(__FILE__, 'Array empty for class constructor.');
    }
  }
  
  public function getStorePacks() {
    return $this->packs;
  }
  
  public function getStorePack($pack) {
    return $this->packs[$pack];
  }
  
  public function addStorePack($pack) {
    $this->packs[$pack->getId()] = $pack;
  }
}