<?php
//die(Helpers::var_dump($user));
$store = new Store($ticraft->call('getAllStorePacks'));

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
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_BUY_PACK', array($pack->getName())), 'success');
        if ($pack->hasItems()) {
          $url = $router->getController('vault')->getUrl();
          header('Location: ' . $url);
          die();
        }
      } else {
        $flash->addFlash('failed buy ' . $store->getStorePack($pack_id), 'warning');
      }
    } else {
      $flash->addFlash('dont have enough money, failed buy ' . $store->getStorePack($pack_id), 'warning');
    }
  } else {
    $flash->addFlash('must be signed in ', 'warning');
    $url = $router->getController('login')->getUrl();
    header('Location: ' . $url);
    die();
  }
  $url = $router->getController('store')->getUrl();
  header('Location: ' . $url);
  die();
}

die($store_twig->render('store.twig', array(
  'manager' => new ServerManager($ticraft->call('getAllServers')),
  'store' => $store,
  'pageTitle' => 'Store',
  'config' => $config,
  'user' => $user,
  'flash' => $flash
)));
/* ============================== */