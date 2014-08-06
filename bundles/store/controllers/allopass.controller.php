<?php

$flash = new Flash;

if (!is_object($user)) {
  $flash = new Flash;
  $flash->addFlash($translator->getTranslation($config->getLang(), 'SIGN_IN_TO_BUY'), 'info');
  Helpers::redirect($router, 'store');
  die();
} elseif (empty($_GET)) {
  die($store_twig->render('allopass.twig', array(
    'pageTitle' => $translator->getTranslation($config->getLang(), 'PURCHASE_MONEY'),
    'config' => $config,
    'user' => $user,
    'flash' => $flash
  )));
} else {
  if (empty($_GET['RECALL'])) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'ERROR_ALLOPASS'), 'warning');
    Helpers::redirect($router, 'store');
    die();
  }
  
  $code = urlencode($_GET['RECALL']);
  $infos = $config->getAllopassInfos();
  $auth = urlencode($infos['full']);
  
  $r = @file('http://payment.allopass.com/api/checkcode.apu?code=' . $code . '&auth=' . $auth);
  
  if (substr($r[0], 0, 2) != 'OK') {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'ERROR_ALLOPASS'), 'warning');
    Helpers::redirect($router, 'store');
    die();
  } else {
    $success = $ticraft->call('userPurchasedMoney', array(
      $user->getId(),
      $config->getMoneyAddedPerCode(),
      $auth,
      $code
    ));
    
    $sum = $config->getMoneyAddedPerCode();
    $temp = $config->getCurrencyName();
    $currency = $sum > 1 ? $temp['plural'] : $temp['singular'];
    
    if ($success) {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_BUY_MONEY', array($sum, $currency)), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_BUY_MONEY'), 'warning');
    }
  }
  
  Helpers::redirect($router, 'store');
  die();
}