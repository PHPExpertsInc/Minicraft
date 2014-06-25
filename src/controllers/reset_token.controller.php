<?php

/* ============================== */
if (is_object($user)) {
  header('Location: ' . URL);
  die();
}
/* ============================== */

/* ============================== */
$token     = strip_tags(trim($_GET['token']));
$password1 = trim($_POST['password1']);
$password2 = trim($_POST['password2']);

$flash = new Flash;
/* ============================== */

/* ============================== */
if (!empty($token) and (empty($password1) or empty($password2))) {
  $infos      = $ticraft->call('getInfosFromResetToken', array(
    $token
  ));
  $date_added = $infos['re_date_added'];
  if ((time() - $date_added) > (60 * 20)) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'TIMEOUT_TRY_AGAIN'), 'warning');
    $url = $router->getController('reset')->getUrl();
    header('Location: ' . URL . '/' . $url);
    die();
  } else {
    // Step 2
    die($twig->render('reset/step_2.twig', array(
      'token' => $token,
      'pageTitle' => $translator->getTranslation($config->getLanguage(), 'RESET'),
      'config' => $config,
      'user' => $user,
      'flash' => $flash
    )));
  }
} elseif (!empty($password1) and !empty($password2) and !empty($token)) {
  /* ============================== */
  if (Helpers::tooShort($password1, 6)) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'PASSWORD_TOO_SHORT'), 'warning');
  } elseif (Helpers::tooLong($password1, 255)) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'PASSWORD_TOO_LONG'), 'warning');
  } elseif ($password1 != $password2) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'PASSWORDS_DONT_MATCH'), 'warning');
  } else {
    $result = $ticraft->call('changePasswordFromToken', array(
      $token,
      $password1
    ));
    if ($result) {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'PASSWORD_CHANGED'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAILED_CHANGE_PASSWORD'), 'warning');
    }
    Security::actionSucceeded('reset');
    
    header('Location: ' . URL);
    die();
  }
  /* ============================== */
  
  $url = $router->getController('reset')->getUrl() . '?token=' . $token;
  header('Location: ' . URL . '/' . $url);
  die();
}
/* ============================== */