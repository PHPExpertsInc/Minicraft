<?php

if (!is_object($user)) {
  $flash = new Flash;
  $flash->addFlash($translator->getTranslation($config->getLang(), 'SIGN_IN_TO_BUY'), 'info');
  Helpers::redirect($router, 'store');
  die();
}

die($store_twig->render('buy.twig', array(
  'pageTitle' => $translator->getTranslation($config->getLang(), 'ADD_MONEY'),
  'config' => $config,
  'user' => $user,
  'flash' => $flash
)));