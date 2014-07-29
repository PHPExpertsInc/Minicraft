<?php

/* ============================== */
if (!is_object($user)) {
  Helpers::redirect($router, 'index');
  die();
}
/* ============================== */

/* ============================== */
$array = $_POST['profile'];

$username     = trim($array['username']);
$email        = trim($array['email']);
$raw_password = trim($array['password']);

$minecraft_username = trim($_POST['minecraft-username']);

$birthdate = strtotime(trim($array['birthdate']));
$genre     = trim($array['genre']);
$country   = trim($array['country']);
$city      = trim($array['city']);
/* ============================== */

/* ============================== */
$error_handler = new ErrorHandler;
$flash         = new Flash;
/* ============================== */

/* ============================== */
if (!empty($username) and $username != $user->getUsername()) {
  if (!$user->getConfirmed()) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'CONFIRM__EMAIL_BEFORE_update_USERNAME'));
    $error_handler->addError('username');
  } elseif (!Helpers::usernameIsValid($username)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'INVALID_USERNAME'), 'username');
    $error_handler->addError('username');
  } elseif (Helpers::tooShort($username, 3)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'USERNAME_TOO_SHORT'), 'username');
    $error_handler->addError('username');
  } elseif (Helpers::tooLong($username, 255)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'USERNAME_TOO_LONG'), 'username');
    $error_handler->addError('username');
  } elseif ($ticraft->call('usernameExists', array(
    $username
  ))) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'USERNAME_EXISTS'), 'username');
    $error_handler->addError('username');
  } else {
    $success = $ticraft->call('updateUsername', array(
      $user->getId(),
      $user->getUsername(),
      $username
    ));
    if ($success) {
      $user->setUsername($username);
      $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_USERNAME'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_USERNAME'), 'warning');
    }
  }
}
/* ============================== */

/* ============================== */
if (!empty($raw_password)) {
  if (Helpers::tooShort($raw_password, 6)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'PASSWORD_TOO_SHORT'), 'password');
    $error_handler->addError('password');
  } elseif (Helpers::tooLong($raw_password, 255)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'PASSWORD_TOO_LONG'), 'password');
    $error_handler->addError('password');
  } else {
    $result = $ticraft->call('updatePassword', array(
      $user->getId(),
      $raw_password
    ));
    
    if (is_string($result)) {
      $user->setPassword($result);
      $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_PASSWORD'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_PASSWORD'), 'warning');
    }
  }
}
/* ============================== */

/* ============================== */
if (!empty($email) and $email != $user->getEmail()) {
  if (!Helpers::emailIsValid($email)) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'EMAIL_INVALID'), 'email');
    $error_handler->addError('email');
  } elseif ($ticraft->call('emailExists', array(
    $email
  ))) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'EMAIL_EXISTS'), 'email');
    $error_handler->addError('email');
  } else {
    $success = $ticraft->call('updateEmail', array(
      $user->getId(),
      $user->getEmail(),
      $email,
      Database::emailAlreadyConfirmed($email)
    ));
    $result  = Database::addEmail($email, $user->getUsername());
    if ($success) {
      if ($result === true) { // Email already confirmed
        $user->setEmail($email);
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_EMAIL'), 'success');
      } else {
        Email::sendConfirmationEmail($email, $user->getUsername(), $result);
        $flash->addFlash($translator->getTranslation($config->getLang(), 'EMAIL_SENT_CONFIRM_EMAIL', array(
          $email
        )), 'info');
      }
    } else {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_EMAIL'), 'warning');
    }
  }
}
/* ============================== */

/* ============================== */
if (!empty($genre) and $genre != $user->getGenre()) {
  if (!in_array($genre, array('unspecified', 'female', 'male'))) {
    $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'GENRE_INCORRECT'), 'genre');
    $error_handler->addError('genre');
  } else {
    $success = $ticraft->call('updateGenre', array(
      $user->getId(),
      $genre
    ));
    if ($success) {
      $user->setGenre($genre);
      $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_GENRE'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_GENRE'), 'warning');
    }
  }
}
/* ============================== */

/* ============================== */
if ($birthdate != $user->getBirthdate() and is_numeric($birthdate)) {
  $success = $ticraft->call('updateBirthdate', array(
    $user->getId(),
    $birthdate
  ));
  if ($success) {
    $user->setBirthdate($birthdate);
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_BIRTHDATE'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_BIRTHDATE'), 'warning');
  }
}
/* ============================== */

/* ============================== */
if (!empty($country) and $country != $user->getCountry()) {
  $success = $ticraft->call('updateCountry', array(
    $user->getId(),
    $country
  ));
  if ($success) {
    $user->setCountry($country);
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_COUNTRY'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_COUNTRY'), 'warning');
  }
}
/* ============================== */

/* ============================== */
if ($city != $user->getCity()) {
  $success = $ticraft->call('updateCity', array(
    $user->getId(),
    $city
  ));
  if ($success) {
    $user->setCity($city);
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_CITY'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_CITY'), 'warning');
  }
}
/* ============================== */

/* ============================== */
if (!empty($_POST)) {
  $error_handler->saveToSessions();
  Helpers::redirect($router, 'profile');
  die();
} else {
  $countries = $translator->getCountries('fr');
  die($twig->render('profile/profile.twig', array(
    'countries' => $countries,
    'handler' => $error_handler,
    'pageTitle' => $translator->getTranslation($config->getLang(), 'PROFILE'),
    'user' => $user,
    'config' => $config,
    'flash' => $flash
  )));
}
/* ============================== */