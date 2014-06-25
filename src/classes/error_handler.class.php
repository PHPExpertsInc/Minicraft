<?php

class ErrorHandler {
  protected $register_errors = array();
  
  protected $register_error_username = false;
  protected $register_error_password = false;
  protected $register_error_email = false;
  
  protected $register_saved_username;
  protected $register_saved_email;
  
  /* ==================== */
  
  protected $login_errors = array();
  
  protected $login_error_username = false;
  protected $login_error_password = false;
  
  protected $login_saved_username;
  protected $login_saved_cookie;
  
  /* ==================== */
  
  protected $profile_errors = array();
  
  protected $profile_error_username = false;
  protected $profile_error_password = false;
  protected $profile_error_email = false;
  protected $profile_error_birthdate = false;
  protected $profile_error_genre = false;
  protected $profile_error_country = false;
  protected $profile_error_city = false;
  
  /* ==================== */
  
  public function __construct() {
    $this->register_errors = empty($_SESSION['register_errors']) ? array() : $_SESSION['register_errors'];
    
    $this->register_error_username = !empty($_SESSION['register_error_username']);
    $this->register_error_password = !empty($_SESSION['register_error_password']);
    $this->register_error_email    = !empty($_SESSION['register_error_email']);
    
    $this->register_saved_username = !empty($_SESSION['register_saved_username']) ? $_SESSION['register_saved_username'] : null;
    $this->register_saved_email    = !empty($_SESSION['register_saved_email']) ? $_SESSION['register_saved_email'] : null;
    
    $this->resetRegisterSessions();
    
    /* ==================== */
    
    $this->login_errors = empty($_SESSION['login_errors']) ? array() : $_SESSION['login_errors'];
    
    $this->login_error_username = !empty($_SESSION['login_error_username']);
    $this->login_error_password = !empty($_SESSION['login_error_password']);
    
    $this->login_saved_username = !empty($_SESSION['login_saved_username']) ? $_SESSION['login_saved_username'] : null;
    
    $this->resetLoginSessions();
    
    /* ==================== */
    
    $this->profile_errors = empty($_SESSION['profile_errors']) ? array() : $_SESSION['profile_errors'];
    
    $this->profile_error_username  = !empty($_SESSION['profile_error_username']);
    $this->profile_error_password  = !empty($_SESSION['profile_error_password']);
    $this->profile_error_email     = !empty($_SESSION['profile_error_email']);
    $this->profile_error_birthdate = !empty($_SESSION['profile_error_birthdate']);
    $this->profile_error_genre     = !empty($_SESSION['profile_error_genre']);
    $this->profile_error_country   = !empty($_SESSION['profile_error_country']);
    $this->profile_error_city      = !empty($_SESSION['profile_error_city']);
    
    $this->resetProfileSessions();
  }
  
  public function saveToSessions() {
    $_SESSION['register_errors'] = $this->register_errors;
    
    $_SESSION['register_error_username'] = $this->register_error_username;
    $_SESSION['register_error_password'] = $this->register_error_password;
    $_SESSION['register_error_email']    = $this->register_error_email;
    
    $_SESSION['register_saved_username'] = $this->register_saved_username;
    $_SESSION['register_saved_email']    = $this->register_saved_email;
    
    /* ==================== */
    
    $_SESSION['login_errors'] = $this->login_errors;
    
    $_SESSION['login_error_username'] = $this->login_error_username;
    $_SESSION['login_error_password'] = $this->login_error_password;
    
    $_SESSION['login_saved_username'] = $this->login_saved_username;
    
    /* ==================== */
    
    $_SESSION['profile_errors'] = $this->profile_errors;
    
    $_SESSION['profile_error_username']  = $this->profile_error_username;
    $_SESSION['profile_error_password']  = $this->profile_error_password;
    $_SESSION['profile_error_email']     = $this->profile_error_email;
    $_SESSION['profile_error_birthdate'] = $this->profile_error_birthdate;
    $_SESSION['profile_error_genre']     = $this->profile_error_genre;
    $_SESSION['profile_error_country']   = $this->profile_error_country;
    $_SESSION['profile_error_city']      = $this->profile_error_city;
  }
  
  public function resetRegisterSessions() {
    unset($_SESSION['register_errors']);
    
    unset($_SESSION['register_error_username']);
    unset($_SESSION['register_error_password']);
    unset($_SESSION['register_error_email']);
    
    unset($_SESSION['register_saved_username']);
    unset($_SESSION['register_saved_email']);
  }
  
  public function resetLoginSessions() {
    unset($_SESSION['login_errors']);
    
    unset($_SESSION['login_error_username']);
    unset($_SESSION['login_error_password']);
    
    unset($_SESSION['login_saved_username']);
    unset($_SESSION['login_saved_cookie']);
  }
  
  public function resetProfileSessions() {
    unset($_SESSION['profile_errors']);
    
    unset($_SESSION['profile_error_username']);
    unset($_SESSION['profile_error_password']);
    unset($_SESSION['profile_error_email']);
    unset($_SESSION['profile_error_birthdate']);
    unset($_SESSION['profile_error_genre']);
    unset($_SESSION['profile_error_country']);
    unset($_SESSION['profile_error_city']);
    unset($_SESSION['profile_error_password']);
  }
  
  /* ==================== */
  
  public function addRegisterError($message, $unshift = false) {
    if ($unshift) {
      array_unshift($this->register_errors, $message);
    } else {
      array_push($this->register_errors, $message);
    }
  }
  
  public function readyToRegister() {
    return (empty($this->register_errors) and empty($this->register_error_username) and empty($this->register_error_password) and empty($this->register_error_email));
  }
  
  public function getRegisterErrors() {
    return $this->register_errors;
  }
  
  public function saveRegisterUsername($username) {
    $this->register_saved_username = $username;
  }
  
  public function saveRegisterEmail($email) {
    $this->register_saved_email = $email;
  }
  
  public function getRegisterSavedUsername() {
    return $this->register_saved_username;
  }
  
  public function getRegisterSavedEmail() {
    return $this->register_saved_email;
  }
  
  public function setRegisterErrorUsername($bool) {
    $this->register_error_username = $bool;
  }
  
  public function setRegisterErrorPassword($bool) {
    $this->register_error_password = $bool;
  }
  
  public function setRegisterErrorEmail($bool) {
    $this->register_error_email = $bool;
  }
  
  public function getRegisterErrorUsername() {
    return $this->register_error_username;
  }
  
  public function getRegisterErrorPassword() {
    return $this->register_error_password;
  }
  
  public function getRegisterErrorEmail() {
    return $this->register_error_email;
  }
  
  public function getRegisterFocusUsername() {
    return ($this->register_error_username and !$this->register_error_password and !$this->register_error_email) or ($this->register_error_username and !$this->register_error_password and $this->register_error_email) or ($this->register_error_username and $this->register_error_password and !$this->register_error_email) or ($this->register_error_username and $this->register_error_password and $this->register_error_email);
  }
  
  public function getRegisterFocusPassword() {
    return (!$this->register_error_username and $this->register_error_password and $this->register_error_email) or (!$this->register_error_username and $this->register_error_password and !$this->register_error_email);
  }
  
  public function getRegisterFocusEmail() {
    return (!$this->register_error_username and !$this->register_error_password and $this->register_error_email);
  }
  
  /* ==================== */
  
  public function addLoginError($message, $unshift = false) {
    if ($unshift) {
      array_unshift($this->login_errors, $message);
    } else {
      array_push($this->login_errors, $message);
    }
  }
  
  public function readyToLogin() {
    return (empty($this->login_errors) and empty($this->login_error_username) and empty($this->login_error_password) and empty($this->login_error_email));
  }
  
  public function getLoginErrors() {
    return $this->login_errors;
  }
  
  public function saveLoginUsername($username) {
    $this->login_saved_username = $username;
  }
  
  public function getLoginSavedUsername() {
    return $this->login_saved_username;
  }
  
  public function getLoginSavedCookie() {
    return $this->login_saved_cookie;
  }
  
  public function setLoginErrorUsername($bool) {
    $this->login_error_username = $bool;
  }
  
  public function setLoginErrorPassword($bool) {
    $this->login_error_password = $bool;
  }
  
  public function getLoginErrorUsername() {
    return $this->login_error_username;
  }
  
  public function getLoginErrorPassword() {
    return $this->login_error_password;
  }
  
  public function saveLoginCookie($bool) {
    $this->login_saved_cookie = $bool;
  }
  
  public function getLoginFocusUsername() {
    return $this->getLoginErrorUsername();
  }
  
  public function getLoginFocusPassword() {
    return (!$this->getLoginErrorUsername() and $this->getLoginErrorPassword());
  }
  
  /* ==================== */
  
  public function addProfileError($message, $unshift = false) {
    if ($unshift) {
      array_unshift($this->profile_errors, $message);
    } else {
      array_push($this->profile_errors, $message);
    }
  }
  
  public function getProfileErrors() {
    return $this->profile_errors;
  }
  
  public function setProfileErrorUsername($bool) {
    $this->profile_error_username = $bool;
  }
  
  public function setProfileErrorPassword($bool) {
    $this->profile_error_password = $bool;
  }
  
  public function setProfileErrorEmail($bool) {
    $this->profile_error_email = $bool;
  }
  
  public function setProfileErrorBirthdate($bool) {
    $this->profile_error_birthdate = $bool;
  }
  
  public function setProfileErrorGenre($bool) {
    $this->profile_error_genre = $bool;
  }
  
  public function setProfileErrorCountry($bool) {
    $this->profile_error_country = $bool;
  }
  
  public function setProfileErrorCity($bool) {
    $this->profile_error_city = $bool;
  }
  
  public function getProfileErrorUsername() {
    return $this->profile_error_username;
  }
  
  public function getProfileErrorPassword() {
    return $this->profile_error_password;
  }
  
  public function getProfileErrorEmail() {
    return $this->profile_error_email;
  }
  
  public function getProfileErrorBirthdate() {
    return $this->profile_error_birthdate;
  }
  
  public function getProfileErrorGenre() {
    return $this->profile_error_genre;
  }
  
  public function getProfileErrorCountry() {
    return $this->profile_error_country;
  }
  
  public function getProfileErrorCity() {
    return $this->profile_error_city;
  }
}