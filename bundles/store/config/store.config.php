<?php

$store_infos = $ticraft->call('getAllStorePacks');
if (!empty($store_infos)) {
  $store = new Store($store_infos);
}

$categories     = array();
$all_categories = $ticraft->call('getAllStoreCategories');
if (!empty($all_categories)) {
  foreach ($all_categories as $category_infos) {
    array_push($categories, new StoreCategory($category_infos));
  }
}

// @todo Items in pack are not already selected - see Twig template
$items     = array();
$all_items = $ticraft->call('getAllStoreItems');
if (!empty($all_items)) {
  foreach ($all_items as $item_infos) {
    array_push($items, new StoreItem($item_infos));
  }
}

$commands     = array();
$all_commands = $ticraft->call('getAllStoreCommands');
if (!empty($all_commands)) {
  foreach ($all_commands as $command_infos) {
    array_push($commands, new StoreCommand($command_infos));
  }
}

$ranks     = array();
$all_ranks = $ticraft->call('getAllRanks');
if (!empty($all_ranks)) {
  foreach ($all_ranks as $rank_infos) {
    array_push($ranks, new Rank($rank_infos));
  }
}

if (!empty($action)) {
  if (preg_match('#^edit-pack-(\d+)#', $action, $matches)) {
    $infos = $ticraft->call('getStorePackInfosFromId', $matches[1]);
    if (!empty($infos)) {
      $pack = new StorePack($infos);
    }
    
    $array             = $_POST['edit-pack'];
    $name              = trim($array['name']);
    $image             = trim($array['image']);
    $description       = trim($array['description']);
    $price             = intval($array['price']);
    $category          = intval($array['category']);
    $selected_items    = $_POST['items'];
    $selected_commands = $_POST['commands'];
    $selected_ranks    = $_POST['ranks'];
    
    if (empty($_POST)) {
      die($store_twig->render('edit_pack.twig', array(
        'pack' => $pack,
        'categories' => $categories,
        'items' => $items,
        'commands' => $commands,
        'ranks' => $ranks,
        'pageTitle' => $translator->getTranslation($config->getLang(), 'EDIT_PACK'),
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
          $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_PACK_NAME'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_PACK_NAME'), 'warning');
        }
      }
      
      if (!empty($image) and $image != $pack->getImage()) {
        $success = $ticraft->call('updatePackImage', array(
          $pack->getId(),
          $image
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_PACK_IMAGE'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_PACK_IMAGE'), 'warning');
        }
      }
      
      if (!empty($description) and $description != $pack->getDescription()) {
        $success = $ticraft->call('updatePackDescription', array(
          $pack->getId(),
          $description
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_PACK_DESCRIPTION'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_PACK_DESCRIPTION'), 'warning');
        }
      }
      
      if (!empty($price) and $price != $pack->getPrice()) {
        $success = $ticraft->call('updatePackPrice', array(
          $pack->getId(),
          $price
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_PACK_PRICE'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_PACK_PRICE'), 'warning');
        }
      }
      
      if (!empty($category) and $category != $pack->getCategory()->getId()) {
        $success = $ticraft->call('updatePackCategory', array(
          $pack->getId(),
          $category
        ));
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_PACK_CATEGORY'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_PACK_CATEGORY'), 'warning');
        }
      }
      
      // @todo Manage the items, commands and ranks
      
      Helpers::redirect($router, 'manage', array(
        'store'
      ));
      die();
    }
  } elseif (preg_match('#^create-pack$#', $action)) {
    $array             = $_POST['create-pack'];
    $name              = trim($array['name']);
    // @todo Allow Imgur hosting like the Blog Bundle
    $image             = trim($array['image']);
    $description       = trim($array['description']);
    $price             = intval($array['price']);
    $category          = intval($array['category']);
    $selected_items    = $_POST['items'];
    $selected_commands = $_POST['commands'];
    $selected_ranks    = $_POST['ranks'];
    $server            = intval($array['server']);
    
    if (empty($_POST)) {
      die($store_twig->render('add_pack.twig', array(
        'categories' => $categories,
        'items' => $items,
        'commands' => $commands,
        'ranks' => $ranks,
        'manager' => new ServerManager($ticraft->call('getAllServers')),
        'pageTitle' => $translator->getTranslation($config->getLang(), 'CREATE_PACK'),
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
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_ADD_PACK'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_ADD_PACK'), 'warning');
      }
      
      Helpers::redirect($router, 'manage', array(
        'store'
      ));
      die();
    }
  } elseif (preg_match('#^add-item$#', $action)) {
    $array          = $_POST['add-item'];
    $minecraft      = explode(';', $array['minecraft']);
    $minecraft_id   = intval($minecraft[0]);
    $minecraft_meta = intval($minecraft[1]);
    $minecraft_name = trim($minecraft[2]);
    $quantity       = intval($array['quantity']);
    $icon           = trim($array['icon']);
    
    if (!empty($array['id'])) {
      $minecraft_id = $array['id'];
    }
    if (!empty($array['meta'])) {
      $minecraft_meta = $array['meta'];
    }
    if (!empty($array['name'])) {
      $minecraft_name = $array['name'];
    }
    if (!empty($array['icon'])) {
      $icon = $array['icon'];
    } else {
      $icon = 'http://cdn.ticraft.fr/items?id=' . $minecraft_id . '&meta=' . $minecraft_meta;
    }
    
    if (empty($_POST)) {
      $minecraft_items = $ticraft->call('getAllMinecraftItems');
      $minecraft_items = array_splice($minecraft_items, 1); // Removes the Air item
      die($store_twig->render('add_item.twig', array(
        'minecraftItems' => $minecraft_items,
        'pageTitle' => $translator->getTranslation($config->getLang(), 'ADD_ITEM'),
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
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_ADD_ITEM'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_ADD_ITEM'), 'warning');
      }
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'store', $url);
      header('Location: ' . URL . '/' . $url);
      die();
    }
  } elseif (preg_match('#^add-command$#', $action)) {
    $array = $_POST['add-command'];
    $command     = trim($array['command']);
    $description = trim($array['description']);
    
    if (empty($command)) { // @todo Check if form was sent with a better method
      die($store_twig->render('add_command.twig', array(
        'pageTitle' => $translator->getTranslation($config->getLang(), 'ADD_COMMAND'),
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
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_ADD_COMMAND'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_ADD_COMMAND'), 'warning');
      }
      
      Helpers::redirect($router, 'manage', array(
        'store'
      ));
      die();
    }
    
  } else {
    Helpers::throw404($twig, $config, $user);
    die();
  }
} elseif (!empty($_POST['remove-pack'])) {
  $flash   = new Flash;
  $id      = intval($_POST['remove-pack']);
  $success = $ticraft->call('removeStorePack', array(
    $id
  ));
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_REMOVE_PACK'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_REMOVE_PACK'), 'warning');
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
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_REMOVE_ITEM'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_REMOVE_ITEM'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'store'
  ));
  die();
} elseif (!empty($_POST['remove-command'])) {
  $flash   = new Flash;
  $id      = intval($_POST['remove-command']);
  $success = $ticraft->call('removeStoreCommand', array(
    $id
  ));
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_REMOVE_COMMAND'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_REMOVE_COMMAND'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'store'
  ));
  die();
} else {
  die($store_twig->render('admin.twig', array(
    'store' => $store,
    'items' => $items,
    'commands' => $commands,
    'pageTitle' => $translator->getTranslation($config->getLang(), 'ADMIN_STORE'),
    'user' => $user,
    'config' => $config,
    'flash' => new Flash
  )));
}