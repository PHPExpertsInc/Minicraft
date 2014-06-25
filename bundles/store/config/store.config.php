<?php

$store_infos = $ticraft->call('getAllStorePacks');
if (!empty($store_infos)) {
  $store = new Store($store_infos);
}

$categories     = array();
$all_categories = $ticraft->call('getAllStoreCategories');
if (!empty($all_categories)) {
  foreach ($all_categories as $key => $value) {
    $categories[] = new StoreCategory($value);
  }
}

// @todo Fix bug here (items in pack are not already selected - see Twig template)

$items     = array();
$all_items = $ticraft->call('getAllStoreItems');
if (!empty($all_items)) {
  foreach ($all_items as $key => $value) {
    $items[] = new StoreItem($value);
  }
}

$commands     = array();
$all_commands = $ticraft->call('getAllStoreCommands');
if (!empty($all_commands)) {
  foreach ($all_commands as $key => $value) {
    $commands[] = new StoreCommand($value);
  }
}

$ranks     = array();
$all_ranks = $ticraft->call('getAllRanks');
if (!empty($all_ranks)) {
  foreach ($all_ranks as $key => $value) {
    $ranks[] = new Rank($value);
  }
}

if (!empty($action)) {
  if (preg_match('#^edit-pack-(\d+)#', $action, $matches)) {
    $pack = new StorePack($ticraft->call('getStorePackInfosFromId', $matches[1]));
    
    $name              = trim($_POST['pack-name']);
    $image             = trim($_POST['pack-image']);
    $description       = trim($_POST['pack-description']);
    $price             = intval($_POST['pack-price']);
    $category          = intval($_POST['pack-category']);
    $selected_items    = $_POST['pack-items'];
    $selected_commands = trim($_POST['pack-commands']);
    $selected_ranks    = trim($_POST['pack-ranks']);
    
    if (empty($name) and empty($image) and empty($description) and empty($price) and empty($category) and empty($selected_items) and empty($selected_commands) and empty($selected_ranks)) {
      die($store_twig->render('edit_pack.twig', array(
        'pack' => $pack,
        'categories' => $categories,
        'items' => $items,
        'commands' => $commands,
        'ranks' => $ranks,
        'pageTitle' => $translator->getTranslation($config->getLanguage(), 'EDIT_PACK'),
        'user' => $user,
        'config' => $config,
        'flash' => new Flash
      )));
    } else {
      $flash = new Flash;
      
      if (!empty($name) and $name != $pack->getName()) {
        $success = $ticraft->call('updatePackName', array(
          $pack->getId(),
          $name
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_PACK_NAME'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_PACK_NAME'), 'warning');
        }
      }
      
      if (!empty($image) and $image != $pack->getImage()) {
        $success = $ticraft->call('updatePackImage', array(
          $pack->getId(),
          $image
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_PACK_IMAGE'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_PACK_IMAGE'), 'warning');
        }
      }
      
      if (!empty($description) and $description != $pack->getDescription()) {
        $success = $ticraft->call('updatePackDescription', array(
          $pack->getId(),
          $description
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_PACK_DESCRIPTION'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_PACK_DESCRIPTION'), 'warning');
        }
      }
      
      if (!empty($price) and $price != $pack->getPrice()) {
        $success = $ticraft->call('updatePackPrice', array(
          $pack->getId(),
          $price
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_PACK_PRICE'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_PACK_PRICE'), 'warning');
        }
      }
      
      if (!empty($category) and $category != $pack->getCategory()->getId()) {
        $success = $ticraft->call('updatePackCategory', array(
          $pack->getId(),
          $category
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_PACK_CATEGORY'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_PACK_CATEGORY'), 'warning');
        }
      }
      
      // @todo Manage the items, commands and ranks
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'store', $url);
      header('Location: ' . URL . '/' . $url);
      die();
    }
  } elseif (preg_match('#^create-pack$#', $action)) {
    $name              = trim($_POST['pack-name']);
    $image             = trim($_POST['pack-image']);
    $description       = trim($_POST['pack-description']);
    $price             = intval($_POST['pack-price']);
    $category          = intval($_POST['pack-category']);
    $selected_items    = $_POST['pack-items'];
    $selected_commands = $_POST['pack-commands'];
    $selected_ranks    = $_POST['pack-ranks'];
    $server            = intval($_POST['pack-server']);
    
    if (empty($name)) {
      die($store_twig->render('add_pack.twig', array(
        'categories' => $categories,
        'items' => $items,
        'commands' => $commands,
        'ranks' => $ranks,
        'manager' => new ServerManager($ticraft->call('getAllServers')),
        'pageTitle' => $translator->getTranslation($config->getLanguage(), 'CREATE_PACK'),
        'user' => $user,
        'config' => $config,
        'flash' => new Flash
      )));
    } else {
      $success = $ticraft->call('addStorePack', array(
        $name,
        $image,
        $description,
        $price,
        $category,
        $selected_items,
        $selected_commands,
        $selected_ranks,
        $server
      ));
      
      $flash = new Flash;
      
      if ($success) {
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_ADD_PACK'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_ADD_PACK'), 'warning');
      }
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'store', $url);
      header('Location: ' . URL . '/' . $url);
      die();
    }
  } elseif (preg_match('#^add-item$#', $action)) {
    $minecraft      = explode(';', $_POST['item-minecraft']);
    $minecraft_id   = intval($minecraft[0]);
    $minecraft_meta = intval($minecraft[1]);
    $minecraft_name = trim($minecraft[2]);
    $quantity       = intval($_POST['item-quantity']);
    $icon           = trim($_POST['item-icon']);
    
    if (!empty($_POST['item-id'])) {
      $minecraft_id = $_POST['item-id'];
    }
    if (!empty($_POST['item-meta'])) {
      $minecraft_meta = $_POST['item-meta'];
    }
    if (!empty($_POST['item-name'])) {
      $minecraft_name = $_POST['item-name'];
    }
    if (!empty($_POST['item-icon'])) {
      $icon = $_POST['item-icon'];
    } else {
      $icon = 'http://cdn.ticraft.fr/items?id=' . $minecraft_id . '&meta=' . $minecraft_meta;
    }
    
    if (empty($quantity)) { // @todo Check more if form sent
      $minecraft_items = $ticraft->call('getAllMinecraftItems');
      $minecraft_items = array_splice($minecraft_items, 1);
      die($store_twig->render('add_item.twig', array(
        'minecraftItems' => $minecraft_items,
        'pageTitle' => $translator->getTranslation($config->getLanguage(), 'ADD_ITEM'),
        'user' => $user,
        'config' => $config,
        'flash' => new Flash
      )));
    } else {
      $success = $ticraft->call('addStoreItem', array(
        $minecraft_id,
        $minecraft_meta,
        $minecraft_name,
        $quantity,
        $icon
      ));
      
      $flash = new Flash;
      
      if ($success) {
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_ADD_ITEM'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_ADD_ITEM'), 'warning');
      }
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'store', $url);
      header('Location: ' . URL . '/' . $url);
      die();
    }
  } elseif (preg_match('#^add-command$#', $action)) {
    $command     = trim($_POST['command-command']);
    $description = trim($_POST['command-description']);
    
    if (empty($command)) { // @todo Check if form was sent with a better method
      die($store_twig->render('add_command.twig', array(
        'pageTitle' => $translator->getTranslation($config->getLanguage(), 'ADD_COMMAND'),
        'user' => $user,
        'config' => $config,
        'flash' => new Flash
      )));
    } else {
      $success = $ticraft->call('addStoreCommand', array(
        $command,
        $description
      ));
      
      $flash = new Flash;
      
      if ($success) {
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_ADD_COMMAND'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_ADD_COMMAND'), 'warning');
      }
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'store', $url);
      header('Location: ' . URL . '/' . $url);
      die();
    }
    
  } else {
    die('404');
  }
} elseif (!empty($_POST['remove-pack'])) {
  $flash   = new Flash;
  $id      = intval($_POST['remove-pack']);
  $success = $ticraft->call('removeStorePack', array(
    $id
  ));
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_REMOVE_PACK'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_REMOVE_PACK'), 'warning');
  }
  
  $url = $router->getController('manage')->getUrl();
  $url = preg_replace('#%m1%#', 'store', $url);
  header('Location: ' . URL . '/' . $url);
  die();
} elseif (!empty($_POST['remove-item'])) {
  $flash   = new Flash;
  $id      = intval($_POST['remove-item']);
  $success = $ticraft->call('removeStoreItem', array(
    $id
  ));
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_REMOVE_ITEM'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_REMOVE_ITEM'), 'warning');
  }
  
  $url = $router->getController('manage')->getUrl();
  $url = preg_replace('#%m1%#', 'store', $url);
  header('Location: ' . URL . '/' . $url);
  die();
} elseif (!empty($_POST['remove-command'])) {
  $flash   = new Flash;
  $id      = intval($_POST['remove-command']);
  $success = $ticraft->call('removeStoreCommand', array(
    $id
  ));
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_REMOVE_COMMAND'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_REMOVE_COMMAND'), 'warning');
  }
  
  $url = $router->getController('manage')->getUrl();
  $url = preg_replace('#%m1%#', 'store', $url);
  header('Location: ' . URL . '/' . $url);
  die();
} else {
  die($store_twig->render('admin.twig', array(
    'store' => $store,
    'items' => $items,
    'commands' => $commands,
    'pageTitle' => $translator->getTranslation($config->getLanguage(), 'ADMIN_STORE'),
    'user' => $user,
    'config' => $config,
    'flash' => new Flash
  )));
}