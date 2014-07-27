<?php

/* ============================== */
preg_match_all($router->getController('verify')->getRegex(), $uri, $matches);
$email = urldecode($matches[1][0]);
$token = $matches[2][0];
/* ============================== */

/* ============================== */
if (!empty($email) and !empty($token)) {
  $infos = Database::getTokenInfosFromEmail($email);
  $flash = new Flash;
  if (empty($infos)) {
    Logger::log(__FILE__, 'Failed sending a confirmation email to ' . $email . '?', 1);
  } elseif (is_numeric($infos['date_confirmed']) and $infos['date_confirmed'] != 0) {
    // Already confirmed
    $flash->addFlash($translator->getTranslation($config->getLang(), 'EMAIL_ALREADY_CONFIRMED'), 'warning');
    Helpers::redirect($router, 'index');
    die();
  } elseif ($token == $infos['token']) {
    Database::confirmEmail($email, $token);
    $ticraft->call('confirmEmail', array(
      $email
    ));
    $flash->addFlash($translator->getTranslation($config->getLang(), 'EMAIL_CONFIRMED'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'TOKEN_INCORRECT'), 'warning');
  }
}
/* ============================== */

Helpers::redirect($router, 'index');
die();