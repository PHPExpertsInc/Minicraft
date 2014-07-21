<?php

if (!is_object($user)) {
  Helpers::redirect($router, 'store');
  die();
}

$flash = new Flash;

$manager_infos = $ticraft->call('getAllServers');
if (!empty($manager_infos)) {
  $manager = new ServerManager($manager_infos);
}

if (is_object($manager)) {
  if (!empty($_POST['send-item'])) {
    $server = $manager->isPlaying($user->getMinecraftUsername());
    if (!empty($server)) {
      $item_infos = $ticraft->call('getStoreItemFromId', array(
        intval($_POST['send-item'])
      ));
      
      if (!empty($item_infos)) {
        $item = new StoreItem($item_infos);
        $success = $ticraft->call('sendItemToUser', array(
          $item->getId(),
          $user->getId()
        ));
      }
      
      if ($success) {
        // @todo Manage multiple servers
        $success = $server->sendItemToUser($user, $item);
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_SEND_ITEM', array($item->getMinecraftName())), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_SEND_ITEM', array($item->getMinecraftName())), 'warning');
        }
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_SEND_ITEM', array($item->getMinecraftName())), 'warning');
      }
    } else {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'PLAYER_NOT_IN_GAME'), 'warning');
    }
    
    Helpers::redirect($router, 'vault');
    die();
  }
}

die($store_twig->render('vault.twig', array(
  'manager' => new ServerManager($ticraft->call('getAllServers')),
  'items' => $items,
  'page_title' => $translator->getTranslation($config->getLang(), 'VAULT'),
  'config' => $config,
  'user' => $user,
  'flash' => $flash
)));