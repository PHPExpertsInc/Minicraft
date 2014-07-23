<?php

class Security {
  
  public static function validateSession($ticraft) {
    session_regenerate_id();
    Database::cleanSessions();
    
    if (isset($_COOKIE['MinicraftCookie'])) {
      $cookie_id = $_COOKIE['MinicraftCookie'];
      $infos = Database::getInfosFromCookieId($cookie_id);
      $user_id      = intval($infos['user_id']);
      $date_expires = intval($infos['date_expires']);
      
      if (!empty($user_id) and time() < $date_expires) {
        $infos = $ticraft->call('getUserInfosFromId', array(
          $user_id
        ));
        if (!empty($infos)) {
          $user = new User($infos);
          $ticraft->call('updateLastLogin', array(
            $user->getId(),
            time()
          ));
        }
      } else {
        self::logOut();
      }
    } elseif (isset($_SESSION['MinicraftSession'])) {
      $session_id = $_SESSION['MinicraftSession'];
      $infos = Database::getInfosFromSessionId($session_id);
      $user_id      = intval($infos['user_id']);
      $date_expires = intval($infos['date_expires']);
      
      if (!empty($user_id) and time() < $date_expires) {
        $infos = $ticraft->call('getUserInfosFromId', array(
          $user_id
        ));
        if (!empty($infos)) {
          $user = new User($infos);
          $ticraft->call('updateLastLogin', array(
            $user->getId(),
            time()
          ));
        }
      } else {
        self::logOut();
      }
    } else {
      self::logOut();
    }
    
    if (!is_object($user)) {
      return false;
    } else {
      $username = $user->getUsername();
      return empty($username) ? false : $user;
    }
  }
  
  public static function logOut() {
    unset($_SESSION['MinicraftSession']);
    setcookie('MinicraftCookie', null, time() - 3600, null, null, false, true);
    unset($_COOKIE['MinicraftCookie']);
  }
  
  public static function userCanDoAction($action, $return_expires = true) {
    $expires = Database::getBruteforceExpires($action);
    
    return $return_expires ? $expires : $expires < time();
  }
  
  public static function actionFailed($action, $max_attempts) {
    $attempts = Database::getBruteforceAttempts($action);
    if ($attempts == null) {
      Database::insertBruteforce($action);
    } else {
      $expires = $attempts > $max_attempts ? (time() + pow($attempts, 3)) : 0;
      Database::updateBruteforce($action, $expires);
    }
  }
  
  public static function actionSucceeded($action) {
    if ($action == 'register') {
      self::actionFailed('register', 3);
    } elseif ($action == 'reset') {
      self::actionFailed('reset', 3);
    } else {
      Database::deleteBruteforce($action);
    }
  }
}