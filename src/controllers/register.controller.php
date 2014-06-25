<?php

/* ============================== */
if (is_object($user)) {
  header('Location: ' . URL);
  die();
}
/* ============================== */

/* ============================== */
$array = $_POST['register'];
$username     = trim($array['username']);
$raw_password = trim($array['password']);
$email        = filter_var(trim($array['email']), FILTER_SANITIZE_EMAIL);

$error_handler = new ErrorHandler;
/* ============================== */

/* ============================== */
if (empty($username) and empty($raw_password) and empty($email)) {
  die($twig->render('register/register.twig', array(
    'pageTitle' => $translator->getTranslation($config->getLanguage(), 'REGISTER'),
    'handler' => $error_handler,
    'config' => $config,
    'user' => $user,
    'flash' => new Flash
  )));
} else {
  $error_handler->saveRegisterUsername($username);
  $error_handler->saveRegisterEmail($email);
  
  /* ============================== */
  $waiting_time = Security::userCanDoAction('register') - time();
  if ($waiting_time > 0) {
    $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'WAIT_BEFORE_REGISTER', array($waiting_time)));
    $error_handler->saveToSessions();
    $url = $router->getController('register')->getUrl();
    header('Location: ' . URL . '/' . $url);
    die();
  }
  /* ============================== */
  
  /* ============================== */
  // Errors in username
  if (empty($username)) {
    $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'USERNAME_EMPTY'));
    $error_handler->setRegisterErrorUsername(true);
  } else {
    if (!Helpers::usernameIsValid($username)) {
      $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'USERNAME_INVALID'));
      $error_handler->setRegisterErrorUsername(true);
    }
    if (Helpers::tooShort($username, 3)) {
      $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'USERNAME_TOO_SHORT', array(3)));
      $error_handler->setRegisterErrorUsername(true);
    }
    if (Helpers::tooLong($username, 16)) {
      $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'USERNAME_TOO_LONG', array(16)));
      $error_handler->setRegisterErrorUsername(true);
    }
  }
  /* ============================== */
  
  /* ============================== */
  // Errors in password
  if (empty($raw_password)) {
    $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'PASSWORD_EMPTY'));
    $error_handler->setRegisterErrorPassword(true);
  } else {
    if (Helpers::tooShort($raw_password, 6)) {
      $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'PASSWORD_TOO_SHORT', array(6)));
      $error_handler->setRegisterErrorPassword(true);
    } elseif (Helpers::tooLong($raw_password, 255)) {
      $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'PASSWORD_TOO_LONG', array(255)));
      $error_handler->setRegisterErrorPassword(true);
    }
  }
  /* ============================== */
  
  /* ============================== */
  // Errors in email address
  if (empty($email)) {
    $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'EMAIL_EMPTY'));
    $error_handler->setRegisterErrorEmail(true);
  } else {
    if (!Helpers::emailIsValid($email)) {
      $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'EMAIL_INCORRECT'));
      $error_handler->setRegisterErrorEmail(true);
    }
  }
  
  /* ============================== */
  // If no error, checks with database
  if ($error_handler->readyToRegister()) {
    /* ============================== */
    if ($ticraft->call('usernameExists', array(
      $username
    ))) {
      $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'USERNAME_ALREADY_EXISTS'), true);
      $error_handler->setRegisterErrorUsername(true);
      $error_handler->saveLoginUsername($username);
    }
    /* ============================== */
    
    /* ============================== */
    if ($ticraft->call('emailExists', array(
      $email
    ))) {
      $error_handler->addRegisterError($translator->getTranslation($config->getLanguage(), 'EMAIL_ALREADY_USED'), true);
      $error_handler->setRegisterErrorEmail(true);
      $error_handler->saveLoginUsername($username);
    }
    /* ============================== */
    
    /* ============================== */
    // If still no error, registers the user
    if ($error_handler->readyToRegister()) {
      $result = $ticraft->call('registerUser', array(
        $username,
        $raw_password,
        $email
      ));
      if (!empty($result)) {
        $flash = new Flash;
        $token = Database::addEmail($email, $username);
        
        /* ============================== */
        if (is_string($token)) {
          Email::sendConfirmationEmail($email, $username, $token);
          Security::actionSucceeded('register');
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'CONFIRMATION_LINK_SENT', array($email)), 'info');
          $user = new User($result);
          $user->generateSession();
        } elseif ($token == true) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'REGISTER_SUCCESS'), 'success');
          $user = new User($result);
          $user->generateSession();
        } else {
          Logger::log(__FILE__, 'Failed sending a confirmation email to ' . $email, 1);
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_SEND_CONFIRMATION_EMAIL'), 'warning');
        }
        /* ============================== */
        
        header('Location: ' . URL);
        die();
      } else {
        Logger::log(__FILE__, 'Registration of user ' . $email . ' failed.', 2);
      }
    }
  }
  /* ============================== */
  
  $error_handler->saveToSessions();
  $url = $router->getController('register')->getUrl();
  header('Location: ' . URL . '/' . $url);
  die();
}