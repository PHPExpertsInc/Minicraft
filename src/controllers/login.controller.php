<?php

/* ============================== */
if (is_object($user)) {
  header('Location: ' . URL);
  die();
}
/* ============================== */

/* ============================== */
$data         = $_POST['login'];
$username     = trim($data['username']);
$raw_password = trim($data['password']);
$cookie       = isset($data['cookie']);

$error_handler = new ErrorHandler;
/* ============================== */


if (empty($username) and empty($raw_password)) {
  die($twig->render('login/login.twig', array(
    'pageTitle' => $translator->getTranslation($config->getLanguage(), 'REGISTER'),
    'handler' => $error_handler,
    'config' => $config,
    'user' => $user,
    'flash' => new Flash
  )));
} else {
  $error_handler->saveLoginUsername($username);
  $error_handler->saveLoginCookie($cookie);
  
  /* ============================== */
  $waiting_time = Security::userCanDoAction('login') - time();
  if ($waiting_time > 0) {
    $error_handler->addLoginError($translator->getTranslation($config->getLanguage(), 'WAIT_BEFORE_LOGIN', array(
      $waiting_time
    )));
    $error_handler->saveToSessions();
    $url = $router->getController('login')->getUrl();
    header('Location: ' . URL . '/' . $url);
    die();
  }
  /* ============================== */
  
  /* ============================== */
  if (empty($username)) {
    $error_handler->addLoginError($translator->getTranslation($config->getLanguage(), 'USERNAME_EMPTY'));
    $error_handler->setLoginErrorUsername(true);
  } elseif (empty($raw_password)) {
    $error_handler->addLoginError($translator->getTranslation($config->getLanguage(), 'PASSWORD_EMPTY'));
    $error_handler->setLoginErrorPassword(true);
  } elseif (!Helpers::usernameIsValid($username) or Helpers::tooShort($username, 3) or Helpers::tooLong($username, 16)) {
    $error_handler->addLoginError($translator->getTranslation($config->getLanguage(), 'USER_UNKNOWN'));
    $error_handler->setLoginErrorUsername(true);
  } elseif (Helpers::tooShort($raw_password, 6) or Helpers::tooLong($raw_password, 255)) {
    $error_handler->addLoginError($translator->getTranslation($config->getLanguage(), 'PASSWORD_INCORRECT'));
    $error_handler->setLoginErrorPassword(true);
    Security::actionFailed('login', 5);
  }
  /* ============================== */
  
  /* ============================== */
  if ($error_handler->readyToLogin()) {
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
      
      if (!empty($_GET['from'])) {
        header('Location: ' . $_GET['from']);
      } elseif (!empty($data['from'])) {
        header('Location: ' . $data['from']);
      } else {
        header('Location: ' . URL);
      }
      
      die();
    } else {
      $error_handler->addLoginError($translator->getTranslation($config->getLanguage(), 'PASSWORD_INCORRECT'));
      $error_handler->setLoginErrorPassword(true);
      Security::actionFailed('login', 5);
    }
  }
  /* ============================== */
  
  $error_handler->saveToSessions();
  $url = $router->getController('login')->getUrl();
  header('Location: ' . URL . '/' . $url);
  die();
}