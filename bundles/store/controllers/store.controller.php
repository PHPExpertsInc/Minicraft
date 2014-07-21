<?php

$store_infos = $ticraft->call('getAllStorePacks');
if (!empty($store_infos)) {
  $store = new Store($store_infos);
}

$flash = new Flash;

if (!empty($_POST['store-buy'])) {
  if (is_object($user)) {
    $pack = $store->getStorePack(intval($_POST['store-buy']));
    if ($user->getMoney() >= $pack->getPrice()) {
      $success = $ticraft->call('userPurchasedPack', array(
        $user->getId(),
        $pack->getId(),
        $pack->getPrice()
      ));
      
      if ($success) {
        $user->setMoney($user->getMoney() - $pack->getPrice());
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_BUY_PACK', array($pack->getName())), 'success');
        if ($pack->hasItems()) {
          Helpers::redirect($router, 'vault');
          die();
        }
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_BUY_PACK', array($pack->getName())), 'warning');
      }
    } else {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_BUY_PACK_NOT_ENOUGH_MONEY', array($pack->getName())), 'warning');
    }
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'MUST_LOGIN_TO_BUY'), 'warning');
    Helpers::redirect($router, 'login');
    die();
  }
  
  Helpers::redirect($router, 'store');
  die();
}

die($store_twig->render('store.twig', array(
  'manager' => new ServerManager($ticraft->call('getAllServers')),
  'store' => $store,
  'pageTitle' => $translator->getTranslation($config->getLang(), 'STORE'),
  'config' => $config,
  'user' => $user,
  'flash' => $flash
)));
/* ============================== */