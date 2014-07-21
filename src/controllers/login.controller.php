<?php

/* ============================== */
if (is_object($user)) {
  Helpers::redirect($router, 'home');
  die();
}
/* ============================== */

/* ============================== */
$array         = $_POST['login'];
$username     = trim($array['username']);
$raw_password = trim($array['password']);
$cookie       = isset($array['cookie']);

$error_handler = new ErrorHandler;
$flash = new Flash;
/* ============================== */


if (empty($_POST)) {
  die($twig->render('login/login.twig', array(
    'pageTitle' => $translator->getTranslation($config->getLang(), 'LOGIN'),
    'handler' => $error_handler,
    'config' => $config,
    'user' => $user,
    'flash' => $flash
  )));
} else {
  $error_handler->saveField('username', $username);
  $error_handler->saveField('cookie', $cookie);
  
  /* ============================== */
  $waiting_time = Security::userCanDoAction('login') - time();
  if ($waiting_time > 0) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'WAIT_BEFORE_LOGIN', array(
      $waiting_time
    )), 'warning');
    $error_handler->saveToSessions();
    Helpers::redirect($router, 'login');
    die();
  }
  /* ============================== */
  
  /* ============================== */
  if (empty($username)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'USERNAME_EMPTY'), 'username');
    $error_handler->addError('username');
  } elseif (empty($raw_password)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'PASSWORD_EMPTY'), 'password');
    $error_handler->addError('password');
  } elseif (!Helpers::usernameIsValid($username) or Helpers::tooShort($username, 3) or Helpers::tooLong($username, 16)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'USER_UNKNOWN'), 'username');
    $error_handler->addError('username');
  } elseif (Helpers::tooShort($raw_password, 6) or Helpers::tooLong($raw_password, 255)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'PASSWORD_INCORRECT'), 'password');
    $error_handler->addError('password');
    Security::actionFailed('login', 5);
  }
  /* ============================== */
  
  /* ============================== */
  if ($error_handler->noError()) {
    $infos = $ticraft->call('checkCredentials', array(
      $username,
      $raw_password
    ));
    
    if (!empty($infos)) {
      $user = new User($infos);
      $user->generateSession();
      
      if ($cookie) {
        $user->generateCookie();
      }
      
      Security::actionSucceeded('login');
      
      if (!empty($array['from'])) {
        header('Location: ' . $array['from']);
        die();
      } else {
        Helpers::redirect($router, 'home');
        die();
      }
    } else {
      $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'PASSWORD_INCORRECT'), 'password');
      $error_handler->addError('password');
      Security::actionFailed('login', 5);
    }
  }
  /* ============================== */
  
  $error_handler->saveToSessions();
  Helpers::redirect($router, 'login');
  die();
}