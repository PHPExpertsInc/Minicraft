<?php

/* ============================== */
if (!is_object($user)) {
  header('Location: ' . URL);
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
    $error_handler->addProfileError($translator->getTranslation($config->getLanguage(), 'CONFIRM__EMAIL_BEFORE_CHANGE_USERNAME'));
    $error_handler->setProfileErrorUsername(true);
  } elseif (!Helpers::usernameIsValid($username)) {
    $error_handler->addProfileError($translator->getTranslation($config->getLanguage(), 'INVALID_USERNAME'));
    $error_handler->setProfileErrorUsername(true);
  } elseif (Helpers::tooShort($username, 3)) {
    $error_handler->addProfileError($translator->getTranslation($config->getLanguage(), 'USERNAME_TOO_SHORT'));
    $error_handler->setProfileErrorUsername(true);
  } elseif (Helpers::tooLong($username, 255)) {
    $error_handler->addProfileError($translator->getTranslation($config->getLanguage(), 'USERNAME_TOO_LONG'));
    $error_handler->setProfileErrorUsername(true);
  } elseif ($ticraft->call('usernameExists', array(
    $username
  ))) {
    $error_handler->addProfileError('username exists');
    $error_handler->setProfileErrorUsername(true);
  } else {
    $success = $ticraft->call('changeUsername', array(
      $user->getId(),
      $user->getUsername(),
      $username
    ));
    if ($success) {
      $user->setUsername($username);
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_USERNAME'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_USERNAME'), 'warning');
    }
  }
}
/* ============================== */

/* ============================== */
if (!empty($email) and $email != $user->getEmail()) {
  if (!Helpers::emailIsValid($email)) {
    $error_handler->addProfileError($translator->getTranslation($config->getLanguage(), 'EMAIL_INVALID'));
    $error_handler->setProfileErrorEmail(true);
  } elseif ($ticraft->call('emailExists', array(
    $email
  ))) {
    $error_handler->addProfileError('email exists');
    $error_handler->setProfileErrorEmail(true);
  } else {
    $success = $ticraft->call('changeEmail', array(
      $user->getId(),
      $user->getEmail(),
      $email,
      Database::emailAlreadyConfirmed($email)
    ));
    $result  = Database::addEmail($email, $user->getUsername());
    if ($success) {
      if ($result === true) { // Email already confirmed
        $user->setEmail($email);
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_EMAIL'), 'success');
      } else {
        Email::sendConfirmationEmail($email, $user->getUsername(), $result);
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'EMAIL_SENT_CONFIRM_EMAIL', array(
          $email
        )), 'info');
      }
    } else {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_EMAIL'), 'warning');
    }
  }
}
/* ============================== */

/* ============================== */
if (!empty($raw_password)) {
  if (Helpers::tooShort($raw_password, 6)) {
    $error_handler->addProfileError($translator->getTranslation($config->getLanguage(), 'PASSWORD_TOO_SHORT'));
    $error_handler->setProfileErrorPassword(true);
  } elseif (Helpers::tooLong($raw_password, 255)) {
    $error_handler->addProfileError($translator->getTranslation($config->getLanguage(), 'PASSWORD_TOO_LONG'));
    $error_handler->setProfileErrorPassword(true);
  } else {
    $result = $ticraft->call('changePassword', array(
      $user->getId(),
      $raw_password
    ));
    
    if (is_string($result)) {
      $user->setPassword($result);
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_PASSWORD'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_PASSWORD'), 'warning');
    }
  }
}
/* ============================== */

/* ============================== */
if (!empty($genre) and $genre != $user->getGenre()) {
  if ($genre != 'unspecified' and $genre != 'female' and $genre != 'male') {
    $error_handler->addProfileError($translator->getTranslation($config->getLanguage(), 'GENRE_INCORRECT'));
    $error_handler->setProfileErrorGenre(true);
  } else {
    $success = $ticraft->call('changeGenre', array(
      $user->getId(),
      $genre
    ));
    if ($success) {
      $user->setGenre($genre);
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_GENRE'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_GENRE'), 'warning');
    }
  }
}
/* ============================== */

/* ============================== */
if (!empty($birthdate) and $birthdate != $user->getBirthdate() and is_numeric($birthdate)) {
  $success = $ticraft->call('changeBirthdate', array(
    $user->getId(),
    $birthdate
  ));
  if ($success) {
    $user->setBirthdate($birthdate);
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_BIRTHDATE'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_BIRTHDATE'), 'warning');
  }
}
/* ============================== */

/* ============================== */
if (!empty($country) and $country != $user->getCountry()) {
  $success = $ticraft->call('changeCountry', array(
    $user->getId(),
    $country
  ));
  if ($success) {
    $user->setCountry($country);
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_COUNTRY'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_COUNTRY'), 'warning');
  }
}
/* ============================== */

/* ============================== */
if (!empty($city) and $city != $user->getCity()) {
  $success = $ticraft->call('changeCity', array(
    $user->getId(),
    $city
  ));
  if ($success) {
    $user->setCity($city);
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_CITY'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_CITY'), 'warning');
  }
}
/* ============================== */

/* ============================== */
if (!empty($_POST)) {
  $error_handler->saveToSessions();
  $url = $router->getController('profile')->getUrl();
  header('Location: ' . URL . '/' . $url);
  die();
} else {
  $countries = $translator->getCountries();
  die($twig->render('profile/profile.twig', array(
    'countries' => $countries,
    'handler' => $error_handler,
    'pagePitle' => $translator->getTranslation($config->getLanguage(), 'PROFILE'),
    'user' => $user,
    'config' => $config,
    'flash' => $flash
  )));
}
/* ============================== */