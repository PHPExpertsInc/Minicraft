<?php

class Security {
  
  public static function validateSession($ticraft) {
    session_regenerate_id();
    $user  = null;
    $query = Database::getInstance()->prepare('DELETE FROM Cookies WHERE date_expires < :timenow');
    $query->execute(array(
      'timenow' => time()
    ));
    $query->closeCursor();
    
    if (isset($_COOKIE['MinicraftCookie'])) {
      $cookie_id = $_COOKIE['MinicraftCookie'];
      
      $query = Database::getInstance()->prepare('SELECT user_id, date_expires FROM Cookies WHERE cookie_id = :cookie_id');
      $query->execute(array(
        'cookie_id' => $cookie_id
      ));
      
      $fetch        = $query->fetch();
      $user_id      = $fetch['user_id'];
      $date_expires = $fetch['date_expires'];
      
      if (!empty($user_id) and time() < $date_expires) {
        $infos = $ticraft->call('getUserInfosFromId', array(
          $user_id
        ));
        if (!empty($infos)) {
          $user = new User($infos);
          $user->updateLastLogin(time());
        }
      } else {
        self::logOut();
      }
    } elseif (isset($_SESSION['MinicraftSession'])) {
      $session_id = $_SESSION['MinicraftSession'];
      
      $query = Database::getInstance()->prepare('SELECT user_id, date_expires FROM Sessions WHERE session_id = :session_id');
      $query->execute(array(
        'session_id' => $session_id
      ));
      
      $fetch        = $query->fetch();
      $user_id      = intval($fetch['user_id']);
      $date_expires = $fetch['date_expires'];
      
      if (!empty($user_id) and time() < $date_expires) {
        $infos = $ticraft->call('getUserInfosFromId', array(
          $user_id
        ));
        if (!empty($infos)) {
          $user = new User($infos);
          $user->updateLastLogin(time());
        }
      } else {
        self::logOut();
      }
    } else {
      self::logOut();
    }
    
    return $user;
  }
  
  public static function logOut() {
    unset($_SESSION['MinicraftSession']);
    setcookie('MinicraftCookie', null, time() - 3600, null, null, false, true);
    unset($_COOKIE['MinicraftCookie']);
  }
  
  public static function userCanDoAction($action, $return_expires = true) {
    $ip = Helpers::getClientIp();
    
    try {
      $query = Database::getInstance()->prepare('SELECT expires FROM Bruteforce WHERE action = :action AND ip = :ip');
      $query->execute(array(
        'action' => $action,
        'ip' => $ip
      ));
      $data = $query->fetch();
    }
    catch (PDOException $e) {
      Logger::log(__FILE__, $e->getMessage());
    }
    
    return $return_expires ? $data['expires'] : $data['expires'] < time();
  }
  
  public static function actionFailed($action, $max_attempts) {
    $ip = Helpers::getClientIp();
    try {
      $query = Database::getInstance()->prepare('SELECT attempts FROM Bruteforce WHERE action = :action AND ip = :ip');
      $query->execute(array(
        'action' => $action,
        'ip' => $ip
      ));
      $data = $query->fetch();
      $query->closeCursor();
    }
    catch (PDOException $e) {
      global $logger;
      Logger::log(__FILE__, $e->getMessage());
    }
    
    $attempts = $data['attempts'];
    
    if ($attempts == null) {
      $query = Database::getInstance()->prepare('INSERT INTO Bruteforce(action, ip, attempts, expires) VALUES(:action, :ip, :attempts, :expires)');
      $query->execute(array(
        'action' => $action,
        'ip' => $ip,
        'attempts' => 1,
        'expires' => 0
      ));
      $query->closeCursor();
    } else {
      $expires = $attempts > $max_attempts ? (time() + pow($attempts, 3)) : 0;
      $query   = Database::getInstance()->prepare('UPDATE Bruteforce SET attempts = attempts + 1, expires = :expires WHERE action = :action AND ip = :ip');
      $query->execute(array(
        'expires' => $expires,
        'action' => $action,
        'ip' => $ip
      ));
      $query->closeCursor();
    }
  }
  
  public static function actionSucceeded($action) {
    if ($action == 'register') {
      self::actionFailed('register', 3);
    } elseif ($action == 'reset') {
      self::actionFailed('reset', 3);
    } else {
      $ip    = Helpers::getClientIp();
      $query = Database::getInstance()->prepare('DELETE FROM Bruteforce WHERE action = :action AND ip = :ip');
      $query->execute(array(
        'action' => $action,
        'ip' => Helpers::getClientIp()
      ));
      $query->closeCursor();
    }
  }
}
