<?php

/* ============================== */
if (is_object($user)) {
  Helpers::redirect($router, 'home');
  die();
}
/* ============================== */

/* ============================== */
$array = $_POST['register'];
$username     = trim($array['username']);
$raw_password = trim($array['password']);
$email        = filter_var(trim($array['email']), FILTER_SANITIZE_EMAIL);

$error_handler = new ErrorHandler;
$flash = new Flash;
/* ============================== */

/* ============================== */
if (empty($_POST)) {
  die($twig->render('register/register.twig', array(
    'handler' => $error_handler,
    'pageTitle' => $translator->getTranslation($config->getLang(), 'REGISTER'),
    'config' => $config,
    'user' => $user,
    'flash' => $flash
  )));
} else {
  $error_handler->save('username', $username);
  $error_handler->save('email', $email);
  
  /* ============================== */
  $waiting_time = Security::userCanDoAction('register') - time();
  if ($waiting_time > 0) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'WAIT_BEFORE_REGISTER', array($waiting_time)), 'warning');
    Helpers::redirect($router, 'register');
    die();
  }
  /* ============================== */
  
  /* ============================== */
  // Errors in username
  if (empty($username)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'USERNAME_EMPTY'), 'username');
    $error_handler->addError('username', true);
  } else {
    if (!Helpers::usernameIsValid($username)) {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'USERNAME_INVALID'), 'username');
      $error_handler->addError('username', true);
    }
    if (Helpers::tooShort($username, 3)) {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'USERNAME_TOO_SHORT', array(3)), 'username');
      $error_handler->addError('username', true);
    }
    if (Helpers::tooLong($username, 16)) {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'USERNAME_TOO_LONG', array(16)), 'username');
      $error_handler->addError('username', true);
    }
  }
  /* ============================== */
  
  /* ============================== */
  // Errors in password
  if (empty($raw_password)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'PASSWORD_EMPTY'), 'password');
    $error_handler->addError('password', true);
  } else {
    if (Helpers::tooShort($raw_password, 6)) {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'PASSWORD_TOO_SHORT', array(6)), 'password');
      $error_handler->addError('password', true);
    } elseif (Helpers::tooLong($raw_password, 255)) {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'PASSWORD_TOO_LONG', array(255)), 'password');
      $error_handler->addError('password', true);
    }
  }
  /* ============================== */
  
  /* ============================== */
  // Errors in email address
  if (empty($email)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'EMAIL_EMPTY'), 'email');
    $error_handler->addError('email', true);
  } else {
    if (!Helpers::emailIsValid($email)) {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'EMAIL_INCORRECT'), 'email');
      $error_handler->addError('email', true);
    }
  }
  
  /* ============================== */
  // If no error, checks with database
  if ($error_handler->noError()) {
    /* ============================== */
    if ($ticraft->call('usernameExists', array(
      $username
    ))) {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'USERNAME_ALREADY_EXISTS'), 'username', true);
      $error_handler->addError('username', true);
    }
    /* ============================== */
    
    /* ============================== */
    if ($ticraft->call('emailExists', array(
      $email
    ))) {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLanguage(), 'EMAIL_ALREADY_USED'), 'email', true);
      $error_handler->addError('email', true);
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
          $flash->addFlash($translator->getTranslation($config->getLang(), 'CONFIRMATION_LINK_SENT', array($email)), 'info');
          $user = new User($result);
          $user->generateSession();
        } elseif ($token == true) {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'REGISTER_SUCCESS'), 'success');
          $user = new User($result);
          $user->generateSession();
        } else {
          Logger::log(__FILE__, 'Failed sending a confirmation email to ' . $email, 1);
          $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_SEND_CONFIRMATION_EMAIL'), 'warning');
        }
        /* ============================== */
        
        Helpers::redirect($router, 'home');
        die();
      } else {
        Logger::log(__FILE__, 'Registration of user ' . $email . ' failed.', 2);
      }
    }
  }
  /* ============================== */
  
  $error_handler->saveToSessions();
  Helpers::redirect($router, 'register');
  die();
}