<?php

class User {
  protected $id;
  protected $username;
  protected $password;
  protected $minecraft_username;
  protected $email;
  protected $genre;
  protected $birthdate;
  protected $city;
  protected $country;
  protected $rank;
  protected $money;
  protected $vault_items = array();
  protected $confirmed;
  protected $banned;
  protected $register_date;
  protected $last_login;
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        if (preg_match('#^u_#', $key)) {
          $key    = str_replace('u_', '', $key);
          $method = 'set' . Helpers::camelCase($key);
          if (method_exists($this, $method)) {
            $this->$method($value);
          }
        }
      }
      
      if (!empty($infos['vault_items'])) {
        foreach ($infos['vault_items'] as $item_infos) {
          if (!empty($item_infos)) {
            $this->addVaultItem(new StoreItem($item_infos));
          }
        }
      }
      
      $this->setRank(new Rank($infos));
      $this->setConfirmed(!empty($this->confirmed));
      $this->setBanned(!empty($this->banned));
    } else {
      Logger::log(__FILE__, 'Array empty for class constructor.');
    }
  }
  
  public function __toString() {
    return $this->username;
  }
  
  public function getVotes() {
    // @todo Code this
    return 3;
  }
  
  public function getTotalVotes() {
    // @todo Code this
    return 9;
  }
  
  public function addVaultItem($item) {
    array_push($this->vault_items, $item);
  }
  
  public function getVaultItems() {
    return $this->vault_items;
  }
  
  public function generateSession($session_expires = 14) {
    Database::generateSession($this->getId(), $session_expires);
  }
  
  public function generateCookie($cookie_expires = 14) {
    Database::generateCookie($this->getId(), $cookie_expires);
  }
  
  public function isConfirmed() {
    return $this->confirmed;
  }
  
  public function isBanned() {
    return $this->banned;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
  
  public function getUsername() {
    return $this->username;
  }
  
  public function setUsername($username) {
    $this->username = $username;
  }
  
  public function getPassword() {
    return $this->password;
  }
  
  public function setPassword($password) {
    $this->password = $password;
  }
  
  public function getMinecraftUsername() {
    return empty($this->minecraft_username) ? $this->username : $this->minecraft_username;
  }
  
  public function setMinecraftUsername($minecraft_username) {
    $this->minecraft_username = $minecraft_username;
  }
  
  public function getEmail() {
    return $this->email;
  }
  
  public function setEmail($email) {
    $this->email = $email;
  }
  
  public function getGenre() {
    return $this->genre;
  }
  
  public function setGenre($genre) {
    $this->genre = $genre;
  }
  
  public function getBirthdate() {
    return $this->birthdate;
  }
  
  public function setBirthdate($birthdate) {
    $this->birthdate = $birthdate;
  }
  
  public function getCity() {
    return $this->city;
  }
  
  public function setCity($city) {
    $this->city = $city;
  }
  
  public function getCountry() {
    return $this->country;
  }
  
  public function setCountry($country) {
    $this->country = $country;
  }
  
  public function getRank() {
    return $this->rank;
  }
  
  public function setRank($rank) {
    $this->rank = $rank;
  }
  
  public function getMoney() {
    return $this->money;
  }
  
  public function setMoney($money) {
    $this->money = $money;
  }
  
  public function getConfirmed() {
    return $this->confirmed;
  }
  
  public function setConfirmed($confirmed) {
    $this->confirmed = $confirmed;
  }
  
  public function getBanned() {
    return $this->banned;
  }
  
  public function setBanned($banned) {
    $this->banned = $banned;
  }
  
  public function getRegisterDate() {
    return $this->register_date;
  }
  
  public function setRegisterDate($register_date) {
    $this->register_date = $register_date;
  }
  
  public function getLastLogin() {
    return $this->last_login;
  }
  
  public function setLastLogin($last_login) {
    $this->last_login = $last_login;
  }
}
