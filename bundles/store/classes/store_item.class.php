<?php

class StoreItem {
  protected $id;
  protected $minecraft_id;
  protected $minecraft_meta;
  protected $minecraft_name;
  protected $slug;
  protected $quantity;
  protected $icon;
  
  public function __construct($infos) {
    foreach ($infos as $key => $value) {
      if (preg_match('#^si_#', $key)) {
        $key    = str_replace('si_', '', $key);
        $method = 'set' . Helpers::camelCase($key);
        if (method_exists($this, $method)) {
          $this->$method($value);
        }
      }
    }
  }
  
  public function __toString() {
    return $this->minecraft_name;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
  
  public function getMinecraftId() {
    return $this->minecraft_id;
  }
  
  public function setMinecraftId($minecraft_id) {
    $this->minecraft_id = $minecraft_id;
  }
  
  public function getMinecraftMeta() {
    return $this->minecraft_meta;
  }
  
  public function setMinecraftMeta($minecraft_meta) {
    $this->minecraft_meta = $minecraft_meta;
  }
  
  public function getMinecraftName() {
    return $this->minecraft_name;
  }
  
  public function setMinecraftName($minecraft_name) {
    $this->minecraft_name = $minecraft_name;
  }
  
  public function getSlug() {
    return $this->slug;
  }
  
  public function setSlug($slug) {
    $this->slug = $slug;
  }
  
  public function getQuantity() {
    return $this->quantity;
  }
  
  public function setQuantity($quantity) {
    $this->quantity = $quantity;
  }
  
  public function getIcon() {
    return $this->icon;
  }
  
  public function setIcon($icon) {
    $this->icon = $icon;
  }
}
