<?php

/* ============================== */
if (is_object($user)) {
  Helpers::redirect($router, 'home');
  die();
}
/* ============================== */

/* ============================== */
$array = $_POST['reset-password'];
$token     = strip_tags(trim($_GET['token']));
$password1 = trim($array['password1']);
$password2 = trim($array['password2']);

$flash = new Flash;
/* ============================== */

/* ============================== */
if (!empty($token) and (empty($password1) or empty($password2))) {
  $infos      = $ticraft->call('getInfosFromResetToken', array(
    $token
  ));
  $date_added = $infos['re_date_added'];
  if ((time() - $date_added) > (60 * 20)) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'TIMEOUT_TRY_AGAIN'), 'warning');
    Helpers::redirect($router, 'reset');
    die();
  } else {
    // Step 2
    die($twig->render('reset/step_2.twig', array(
      'token' => $token,
      'pageTitle' => $translator->getTranslation($config->getLang(), 'RESET'),
      'config' => $config,
      'user' => $user,
      'flash' => $flash
    )));
  }
} elseif (!empty($password1) and !empty($password2) and !empty($token)) {
  /* ============================== */
  if (Helpers::tooShort($password1, 6)) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'PASSWORD_TOO_SHORT'), 'warning');
  } elseif (Helpers::tooLong($password1, 255)) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'PASSWORD_TOO_LONG'), 'warning');
  } elseif ($password1 != $password2) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'PASSWORDS_DO_NOT_MATCH'), 'warning');
  } else {
    $result = $ticraft->call('changePasswordFromToken', array(
      $token,
      $password1
    ));
    if ($result) {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'PASSWORD_CHANGED'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'FAILED_CHANGE_PASSWORD'), 'warning');
    }
    Security::actionSucceeded('reset');
    
    Helpers::redirect($router, 'home');
    die();
  }
  /* ============================== */
  
  $url = $router->getController('reset')->getUrl() . '?token=' . $token;
  header('Location: ' . URL . '/' . $url);
  die();
}
/* ============================== */