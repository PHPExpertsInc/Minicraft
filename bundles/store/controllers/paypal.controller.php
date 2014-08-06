<?php

$flash = new Flash;

if (!is_object($user)) {
  $flash = new Flash;
  $flash->addFlash($translator->getTranslation($config->getLang(), 'SIGN_IN_TO_BUY'), 'info');
  Helpers::redirect($router, 'store');
  die();
} elseif (empty($_POST)) {
  die($store_twig->render('paypal.twig', array(
    'pageTitle' => $translator->getTranslation($config->getLang(), 'PURCHASE_MONEY'),
    'config' => $config,
    'user' => $user,
    'flash' => $flash
  )));
} else {
  die(Helpers::var_dump($_POST));
  
  Helpers::redirect($router, 'store');
  die();
}