<?php

class StorePack {
  protected $id;
  protected $name;
  protected $slug;
  protected $description;
  protected $image;
  protected $price;
  protected $category;
  protected $items = array();
  protected $ranks = array();
  protected $commands = array();
  protected $servers = array();
  
  public function __construct($infos) {
    foreach ($infos as $key => $value) {
      if (preg_match('#^sp_#', $key)) {
        $key    = str_replace('sp_', '', $key);
        $method = 'set' . Helpers::camelCase($key);
        if (method_exists($this, $method)) {
          $this->$method($value);
        }
      }
      
      $this->setCategory(new StoreCategory($infos));
    }
    
    if (!empty($infos['items'])) {
      foreach ($infos['items'] as $key => $value) {
        $item = new StoreItem($value);
        $this->addItem($item);
      }
    }
    
    if (!empty($infos['commands'])) {
      foreach ($infos['commands'] as $key => $value) {
        $command = new StoreCommand($value);
        $this->addCommand($command);
      }
    }
    
    if (!empty($infos['ranks'])) {
      foreach ($infos['ranks'] as $key => $value) {
        $rank = new Rank($value);
        $this->addRank($rank);
      }
    }
    
    $this->setCategory(new StoreCategory($infos));
  }
  
  public function hasItems() {
    return !empty($this->items);
  }
  
  public function getStoreItems() {
    return $this->items;
  }
  
  public function getStoreCommands() {
    return $this->commands;
  }
  
  public function getRanks() {
    return $this->ranks;
  }
  
  public function __toString() {
    return $this->getName();
  }
  
  public function addItem($item) {
    $this->items[] = $item;
  }
  
  public function addRank($rank) {
    $this->ranks[] = $rank;
  }
  
  public function addCommand($command) {
    $this->commands[] = $command;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function setName($name) {
    $this->name = $name;
  }
  
  public function getSlug() {
    return $this->slug;
  }
  
  public function setSlug($slug) {
    $this->slug = $slug;
  }
  
  public function getDescription() {
    return $this->description;
  }
  
  public function setDescription($description) {
    $this->description = $description;
  }
  
  public function getImage() {
    return $this->image;
  }
  
  public function setImage($image) {
    $this->image = $image;
  }
  
  public function getPrice() {
    return $this->price;
  }
  
  public function setPrice($price) {
    $this->price = $price;
  }
  
  public function getCategory() {
    return $this->category;
  }
  
  public function setCategory($category) {
    $this->category = $category;
  }
}
