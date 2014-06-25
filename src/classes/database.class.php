<?php

class Database {
  protected static $db = null;
  
  protected static function init() {
    try {
      self::$db = new PDO('sqlite:' . DB);
    }
    catch (Exception $e) {
      // die('<pre>' . $e->getMessage() . '</pre>');
    }
  }
  
  public static function getInstance() {
    if (self::$db == null) {
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
      catch (Exception $e) {
        return false;
      }
      
      return $token;
    }
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
    catch (Exception $e) {
      return false;
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
}
