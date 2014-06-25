<?php

if (!is_object($user)) {
  $url = $router->getController('store')->getUrl();
  header('Location: ' . $url);
  die();
}

$flash = new Flash;
$manager = new ServerManager($ticraft->call('getAllServers'));

if (!empty($_POST['send-item'])) {
  $server = $manager->isPlaying($user->getMinecraftUsername());
  
  if (!empty($server)) {
    $item    = new StoreItem($ticraft->call('getStoreItemFromId', array(
      intval($_POST['send-item'])
    )));
    
    $success = $ticraft->call('sendItemToUser', array(
      $item->getId(),
      $user->getId()
    ));
    if ($success) {
      // @todo Manage multiple servers
      $success = $server->sendItemToUser($user, $item);
      if ($success) {
        $flash->addFlash('envoie de ' . $item->getMinecraftName() . ' réussi', 'success');
      } else {
        $flash->addFlash('failed send ' . $item->getMinecraftName(), 'warning');
      }
    } else {
      $flash->addFlash('failed send ' . $item->getMinecraftName(), 'warning');
    }
  } else {
    $flash->addFlash('not in game', 'warning');
  }
  
  $url = $router->getController('vault')->getUrl();
  header('Location: ' . URL . '/' . $url);
  die();
}

die($store_twig->render('vault.twig', array(
  'manager' => new ServerManager($ticraft->call('getAllServers')),
  'items' => $items,
  'page_title' => 'Vault',
  'lang_gold' => 'Gold',
  'config' => $config,
  'user' => $user,
  'flash' => $flash
)));