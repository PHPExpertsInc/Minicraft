<?php

class ErrorHandler {
  protected $errors = array();
  protected $error_messages = array();
  protected $saved_fields = array();
  
  /* ==================== */
  
  public function __construct() {
    $this->errors = empty($_SESSION['errors']) ? array() : $_SESSION['errors'];
    $this->error_messages = empty($_SESSION['error_messages']) ? array() : $_SESSION['error_messages'];
    $this->saved_fields = empty($_SESSION['saved_fields']) ? array() : $_SESSION['saved_fields'];
    
    $this->resetSessions();
  }
  
  public function saveToSessions() {
    $_SESSION['errors'] = $this->errors;
    $_SESSION['error_messages'] = $this->error_messages;
    $_SESSION['saved_fields'] = $this->saved;
  }
  
  public function resetSessions() {
    unset($_SESSION['errors']);
    unset($_SESSION['error_messages']);
    unset($_SESSION['saved_fields']);
  }
  
  /* ==================== */
  
  public function addErrorMessage($message, $field, $unshift = false) {
    if (!empty($field)) {
      $this->error_messages[$field] = $message;
    } else {
      if ($unshift) {
        array_unshift($this->error_messages, $message);
      } else {
        array_push($this->error_messages, $message);
      }
    }
  }
  
  public function addError($field, $bool = true) {
    $this->errors[$field] = $bool;
  }
  
  public function noError() {
    return (empty($this->error_messages) and empty($this->errors));
  }
  
  public function getErrors() {
    return $this->errors;
  }
  
  public function getErrorMessages() {
    return $this->error_messages;
  }
  
  public function saveField($field, $data) {
    $this->saved_ields[$field] = $data;
  }
  
  public function getSavedField($field) {
    return $this->saved_ields[$field];
  }
  
  /* ==================== */
  
  public function getRegisterFocusUsername() {
    return ($this->error_username and !$this->error_password and !$this->error_email) or ($this->error_username and !$this->error_password and $this->error_email) or ($this->error_username and $this->error_password and !$this->error_email) or ($this->error_username and $this->error_password and $this->error_email);
  }
  
  public function getRegisterFocusPassword() {
    return (!$this->error_username and $this->error_password and $this->error_email) or (!$this->error_username and $this->error_password and !$this->error_email);
  }
  
  public function getRegisterFocusEmail() {
    return (!$this->error_username and !$this->error_password and $this->error_email);
  }
  
  /* ==================== */
    
  public function getLoginFocusUsername() {
    return $this->errors['username'];
  }
  
  public function getLoginFocusPassword() {
    return (!$this->errors['username'] and $this->errors['password']);
  }
}