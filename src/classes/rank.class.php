<?php

class Rank {
  protected $id;
  protected $name;
  protected $slug;
  protected $force;
  protected $users = array();
  
  public function __construct($infos) {
    foreach ($infos as $key => $value) {
      if (preg_match('#^r_#', $key)) {
        $key    = str_replace('r_', '', $key);
        $method = 'set' . Helpers::camelCase($key);
        if (method_exists($this, $method)) {
          $this->$method($value);
        }
      } elseif ($key === 'users') {
        foreach ($value as $user_infos) {
          $this->addUser(new User($user_infos));
        }
      }
    }
  }
  
  public function __toString() {
    return empty($this->name) ? 'Unknown Rank' : $this->name;
  }
  
  public function addUser($user) {
    $this->users[] = $user;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
  
  public function setName($name) {
    $this->name = $name;
  }
  
  public function setSlug($slug) {
    $this->slug = $slug;
  }
  
  public function setForce($force) {
    $this->force = $force;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function getSlug() {
    return $this->slug;
  }
  
  public function getForce() {
    return $this->force;
  }
}
