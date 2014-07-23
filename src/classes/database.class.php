<?php

class Database {
  protected static $db = null;
  
  protected static function init() {
    try {
      self::$db = new PDO('sqlite:' . DB);
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
  }
  
  public static function getInstance() {
    if (!is_object(self::$db)) {
      self::init();
    }
    
    return self::$db;
  }
  
  public static function addEmail($email, $username) {
    $result = self::emailAlreadyConfirmed($email);
    if ($result === true) { // Email already confirmed
      return true;
    } elseif (is_string($result)) { // Email already registered but not confirmed yet (resending the token)
      return $result;
    } else {
      $token = Helpers::randomString(32);
      try {
        $query = self::getInstance()->prepare('INSERT INTO Emails(email, token, date_added) VALUES(:email, :token, :date_added)');
        $query->execute(array(
          'email' => $email,
          'token' => $token,
          'date_added' => time()
        ));
        $query->closeCursor();
      }
      catch (PDOException $e) {
        Logger::log(__FILE__, $e->getMessage());
      }
      
      return $token;
    }
  }
  
  public static function getTokenInfosFromEmail($email) {
    try {
      $query = self::getInstance()->prepare('SELECT token, date_confirmed FROM Emails WHERE email = :email');
      $query->execute(array(
        'email' => $email
      ));
      $data = $query->fetch();
      $query->closeCursor;
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return $data;
  }
  
  public static function confirmEmail($email, $token) {
    try {
      $query = self::getInstance()->prepare('UPDATE Emails SET date_confirmed = :date_confirmed WHERE email = :email AND token = :token');
      $query->execute(array(
        'date_confirmed' => time(),
        'email' => $email,
        'token' => $token
      ));
      $query->closeCursor;
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return true;
  }
  
  public static function emailAlreadyConfirmed($email) {
    try {
      $query = self::getInstance()->prepare('SELECT token, date_confirmed FROM Emails WHERE email = :email');
      $query->execute(array(
        'email' => $email
      ));
      $data = $query->fetch();
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    $token          = $data['token'];
    $date_confirmed = $data['date_confirmed'];
    
    if (is_numeric($date_confirmed) and $date_confirmed > 0) {
      return true;
    } elseif ($date_confirmed === 0) {
      return $token;
    } else {
      return false;
    }
  }
  
  public static function getSessionExpires() {
    // @todo Take this from DB
    return 14;
  }
  
  public static function getCookieExpires() {
    // @todo Take this from DB
    return 14;
  }
  
  public static function cleanSessions() {
    try {
      $query = self::getInstance()->prepare('DELETE FROM Cookies WHERE date_expires < :timenow');
      $query->execute(array(
        'timenow' => time()
      ));
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    try {
      $query = self::getInstance()->prepare('DELETE FROM Sessions WHERE date_expires < :timenow');
      $query->execute(array(
        'timenow' => time()
      ));
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
  }
  
  public static function getInfosFromCookieId($cookie_id) {
    try {
      $query = self::getInstance()->prepare('SELECT user_id, date_expires FROM Cookies WHERE cookie_id = :cookie_id');
      $query->execute(array(
        'cookie_id' => $cookie_id
      ));
      $data = $query->fetch();
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return $data;
  }
  
  public static function getInfosFromSessionId($session_id) {
    try {
      $query = self::getInstance()->prepare('SELECT user_id, date_expires FROM Sessions WHERE session_id = :session_id');
      $query->execute(array(
        'session_id' => $session_id
      ));
      $data = $query->fetch();
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return $data;
  }
  
  public static function insertCookieId($admin_id, $cookie_id) {
    try {
      $query = self::getInstance()->prepare('INSERT INTO Cookies(admin_id, cookie_id, date_added, date_expires) VALUES(:admin_id, :cookie_id, :date_added, :date_expires)');
      $query->execute(array(
        'admin_id' => $admin_id,
        'cookie_id' => $cookie_id,
        'date_added' => time(),
        'date_expires' => time() + (14 * 24 * 60 * 60)
      ));
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return true;
  }
  
  public static function insertSessionId($admin_id, $session_id) {
    try {
      $query = self::getInstance()->prepare('INSERT INTO Sessions(admin_id, session_id, date_added, date_expires) VALUES(:admin_id, :session_id, :date_added, :date_expires)');
      $query->execute(array(
        'admin_id' => $admin_id,
        'session_id' => $session_id,
        'date_added' => time(),
        'date_expires' => time() + (14 * 24 * 60 * 60)
      ));
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return true;
  }
  
  public static function getBruteForceExpires($action) {
    try {
      $query = self::getInstance()->prepare('SELECT expires FROM Bruteforce WHERE action = :action AND ip = :ip');
      $query->execute(array(
        'action' => $action,
        'ip' => Helpers::getClientIp()
      ));
      $data = $query->fetch();
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return $data['expires'];
  }
  
  public static function getBruteforceAttempts($action) {
    try {
      $query = self::getInstance()->prepare('SELECT attempts FROM Bruteforce WHERE action = :action AND ip = :ip');
      $query->execute(array(
        'action' => $action,
        'ip' => Helpers::getClientIp()
      ));
      $data = $query->fetch();
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return $data['attemps'];
  }
  
  public static function insertBruteforce($action) {
    try {
      $query = self::getInstance()->prepare('INSERT INTO Bruteforce(action, ip, attempts, expires) VALUES(:action, :ip, :attempts, :expires)');
      $query->execute(array(
        'action' => $action,
        'ip' => Helpers::getClientIp(),
        'attempts' => 1,
        'expires' => 0
      ));
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
  }
  
  public static function updateBruteforce($action, $expires) {
    try {
      $query = self::getInstance()->prepare('UPDATE Bruteforce SET attempts = attempts + 1, expires = :expires WHERE action = :action AND ip = :ip');
      $query->execute(array(
        'expires' => $expires,
        'action' => $action,
        'ip' => Helpers::getClientIp()
      ));
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
  }
  
  public static function deleteBruteforce($action) {
    try {
      $query = Database::getInstance()->prepare('DELETE FROM Bruteforce WHERE action = :action AND ip = :ip');
      $query->execute(array(
        'action' => $action,
        'ip' => Helpers::getClientIp()
      ));
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
  }
  
  public static function getApiInfos() {
    try {
      $query = self::getInstance()->query('SELECT username, api_key FROM Config');
      $data  = $query->fetch();
      $query->closeCursor();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return $data;
  }
  
  public static function generateSession($user_id, $session_expires = 14) {
    $session_id = Helpers::randomKey(32);
    $query      = self::getInstance()->prepare('INSERT INTO Sessions(user_id, session_id, date_added, date_expires) VALUES(:user_id, :session_id, :date_added, :date_expires)');
    $query->execute(array(
      'user_id' => $user_id,
      'session_id' => $session_id,
      'date_added' => time(),
      'date_expires' => time() + ($session_expires * 24 * 60 * 60)
    ));
    $query->closeCursor();
    $_SESSION['MinicraftSession'] = $session_id;
  }
  
  public static function generateCookie($user_id, $cookie_expires = 14) {
    $cookie_id = Helpers::randomKey(32);
    $query     = Database::getInstance()->prepare('INSERT INTO Cookies(user_id, cookie_id, date_added, date_expires) VALUES(:user_id, :cookie_id, :date_added, :date_expires)');
    $query->execute(array(
      'user_id' => $user_id,
      'cookie_id' => $cookie_id,
      'date_added' => time(),
      'date_expires' => time() + ($cookie_expires * 24 * 60 * 60)
    ));
    $query->closeCursor();
    setcookie('MinicraftCookie', $cookie_id, $cookie_expires, null, null, false, true);
  }
}
