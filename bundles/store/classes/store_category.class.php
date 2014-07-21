<?php

class StoreCategory {
  protected $id;
  protected $name;
  protected $slug;
  protected $description;
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        if (preg_match('#^cat_#', $key)) {
          $key    = str_replace('cat_', '', $key);
          $method = 'set' . Helpers::camelCase($key);
          if (method_exists($this, $method)) {
            $this->$method($value);
          }
        }
      }
    } else {
      Logger::log(__FILE__, 'Array empty for class constructor.');
    }
  }
  
  public function __toString() {
    return $this->getName();
  }
  
  public function addItem($item) {
    array_push($this->items, $item);
  }
  
  public function addRank($rank) {
    array_push($this->ranks, $rank);
  }
  
  public function addCommand($command) {
    array_push($this->commands, $command);
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
