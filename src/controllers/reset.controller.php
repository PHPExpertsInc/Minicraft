<?php

/* ============================== */
if (is_object($user)) {
  Helpers::redirect($router, 'index');
  die();
}
/* ============================== */

/* ============================== */
$account = trim($_POST['account']);
$flash = new Flash;
/* ============================== */

/* ============================== */
if (empty($account)) {
  die($twig->render('reset/step_1.twig', array(
    'pageTitle' => $translator->getTranslation($config->getLang(), 'RESET_PASSWORD'),
    'config' => $config,
    'user' => $user,
    'flash' => $flash
  )));
} elseif (Helpers::usernameIsValid($account)) {
  $user_infos = $ticraft->call('getUserInfosFromUsername', array(
    $account
  ));
} elseif (Helpers::emailIsValid($account)) {
  $user_infos = $ticraft->call('getUserInfosFromEmail', array(
    $account
  ));
}
/* ============================== */

/* ============================== */
$waiting_time = Security::userCanDoAction('reset') - time();
if ($waiting_time > 0) {
  $flash->addFlash($translator->getTranslation($config->getLang(), 'WAIT_BEFORE_RESET', array($waiting_time)));
  Helpers::redirect($router, 'reset');
  die();
}
/* ============================== */

/* ============================== */
if (empty($user_infos)) {
  // Step 1 sent but error
  $flash->addFlash($translator->getTranslation($config->getLang(), 'NO_ACCOUNT_MATCHING'), 'warning');
  Helpers::redirect($router, 'reset');
  die();
} else {
  // Step 1 sent no error
  $user  = new User($user_infos);
  $token = $ticraft->call('generateResetToken', array(
    $user->getId()
  ));
  
  Email::sendResetPasswordEmail($user->getEmail(), $user->getUsername(), $token, $translator, $config, $router);
  
  $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_RESET'), 'success');
  
  Helpers::redirect($router, 'index');
  die();
}
/* ============================== */