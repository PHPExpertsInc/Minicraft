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
      foreach ($infos['vault_items'] as $key => $value) {
        $this->addVaultItem(new StoreItem($value));
      }
    }
    
    $this->setRank(new Rank($infos));
    $this->setConfirmed(!empty($this->confirmed));
    $this->setBanned(!empty($this->banned));
  }
  
  public function __toString() {
    return $this->username;
  }
  
  public function getVotes() {
    return 3;
  }
  
  public function getTotalVotes() {
    return 9;
  }
  
  public function addVaultItem($item) {
    $this->vault_items[] = $item;
  }
  
  public function getVaultItems() {
    return $this->vault_items;
  }
  
  public function banUser($reason = '', $hours = 0, $email = false) {
    $expires = $hours > 0 ? time() + 3600 * $hours : time() + 3600 * 999999;
    $result  = Ticraft::banUser($this, $reason, $hours);
    if ($result AND $email) {
      Email::sendBanEmail($this, $reason, $expires);
    }
    $this->banned = true;
    $this->save();
    
    return $result;
  }
  
  public function unbanUser($email) {
    Ticraft::unbanUser($this);
    if ($email) {
      Email::sendUnbanEmail($this);
    }
    $this->banned = false;
    $this->save();
  }
  
  public function buyStorePack($store_pack) {
    if ($this->money >= $store_pack->getPrice()) {
      $server = new Server;
      $server->hydrate($store_pack->getServerId());
      $online_players = $server->getOnlinePlayersUsernames;
      if (!in_array($this->mc_username, $online_players)) {
        // If user is not in game
        $result = Ticraft::purchasePack($this, $store_pack, false);
      } else {
        // If user is in game
        $send = $server->givePack($this, $store_pack);
        if ($send) {
          $result = Ticraft::purchasePack($this, $store_pack, true);
        } else {
          $result = Ticraft::purchasePack($this, $store_pack, false);
        }
      }
      $this->removeMoney($store_pack->getPrice());
      $this->save();
    } else {
      $result = false;
    }
    
    return $result;
  }
  
  public function generateCookie() {
    global $config;
    $cookie_id = Helpers::randomKey(32);
    $query     = Database::getInstance()->prepare('INSERT INTO Cookies(user_id, cookie_id, date_added, date_expires) VALUES(:user_id, :cookie_id, :date_added, :date_expires)');
    $query->execute(array(
      'user_id' => $this->getId(),
      'cookie_id' => $cookie_id,
      'date_added' => time(),
      'date_expires' => time() + ($config->getCookieExpires() * 24 * 60 * 60)
    ));
    $query->closeCursor();
    setcookie('MinicraftCookie', $cookie_id, $config->getCookieExpires(), null, null, false, true);
  }
  
  public function generateSession() {
    global $config;
    $session_id = Helpers::randomKey(32);
    $query      = Database::getInstance()->prepare('INSERT INTO Sessions(user_id, session_id, date_added, date_expires) VALUES(:user_id, :session_id, :date_added, :date_expires)');
    $query->execute(array(
      'user_id' => $this->getId(),
      'session_id' => $session_id,
      'date_added' => time(),
      'date_expires' => time() + ($config->getSessionExpires() * 24 * 60 * 60)
    ));
    $query->closeCursor();
    $_SESSION['MinicraftSession'] = $session_id;
  }
  
  public function getConfirmationToken() {
    $confirmation_token = Ticraft::getConfirmationToken($this);
    
    return empty($confirmation_token) ? false : $confirmation_token;
  }
  
  public function removeResetToken() {
    $result = Ticraft::removeResetToken($this);
    
    return $result;
  }
  
  public function createResetToken() {
    Ticraft::removeResetToken($this);
    $token = Ticraft::createResetToken($this);
    
    return $token;
  }
  
  public function getResetToken() {
    $token = Ticraft::getResetToken($this);
    
    return $token;
  }
  
  public function removeMoney($amount) {
    if ($this->money >= $amount) {
      $result = Ticraft::removeMoney($amount);
      if ($result) {
        $this->money = $this->money - $amount;
      }
    } else {
      $result = Ticraft::setMoney(0);
      if ($result) {
        $this->money = 0;
      }
    }
    
    return $result;
  }
  
  public function updateUsername($username) {
    $result = Ticraft::updateUsername($this, $username);
    
    return $result;
  }
  
  public function updatePassword($password) {
    $result = Ticraft::updatePassword($this, $password);
    
    return $result;
  }
  
  public function updateEmail($email) {
    $result = Ticraft::updateEmail($this, $email);
    
    return $result;
  }
  
  public function updateBirthdate($birthdate) {
    $result = Ticraft::updateBirthdate($this, $birthdate);
    
    return $result;
  }
  
  public function updateGenre($genre) {
    $result = Ticraft::updateGenre($this, $genre);
    
    return $result;
  }
  
  public function updateCity($city) {
    $result = Ticraft::updateCity($this, $city);
    
    return $result;
  }
  
  public function updateCountry($country) {
    $result = Ticraft::updateCountry($this, $country);
    
    return $result;
  }
  
  public function updateLastLogin($last_login) {
    global $ticraft;
    $result = $ticraft->call('updateLastLogin', array(
      $this,
      $last_login
    ));
    
    return $result;
  }
  
  public function updateConfirmationStatus($confirmation) {
    $result = Ticraft::updateConfirmationStatus($this, $confirmation);
    
    return $result;
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
