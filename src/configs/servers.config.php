<?php

if (!empty($action)) {
  if (preg_match('#^edit-server-(\d+)#', $action, $matches)) {
    $types     = array();
    $all_types = $ticraft->call('getAllServerTypes');
    foreach ($all_types as $key => $value) {
      $types[] = new ServerType($value);
    }
    $server = new Server($ticraft->call('getServerInfosFromId', $matches[1]));
    if (empty($_POST['server-name']) and empty($_POST['server-ip']) and empty($_POST['server-description']) and empty($_POST['server-type']) and empty($_POST['server-type']) and empty($_POST['server-jsonapi-port']) and empty($_POST['server-jsonapi-username']) and empty($_POST['server-jsonapi-password'])) {
      die($twig->render('admin/edit_server.twig', array(
        'server' => $server,
        'types' => $types,
        'page_title' => 'Edit server',
        'user' => $user,
        'config' => $config,
        'flash' => new Flash
      )));
    } else {
      $flash            = new Flash;
      $name             = trim($_POST['server-name']);
      $ip               = trim($_POST['server-ip']);
      $description      = trim($_POST['server-description']);
      $type             = intval($_POST['server-type']);
      $jsonapi_port     = intval($_POST['server-jsonapi-port']);
      $jsonapi_username = trim($_POST['server-jsonapi-username']);
      $jsonapi_password = trim($_POST['server-jsonapi-password']);
      
      if (!empty($name) and $name != $server->getName()) {
        $success = $ticraft->call('updateServerName', array(
          $server->getId(),
          $name
        ));
        if ($success) {
          $flash->addFlash('success changing server name', 'success');
        } else {
          $flash->addFlash('failed changing server name', 'warning');
        }
      }
      
      if (!empty($ip) and $ip != $server->getIp()) {
        $success = $ticraft->call('updateServerIp', array(
          $server->getId(),
          $ip
        ));
        if ($success) {
          $flash->addFlash('success changing server ip', 'success');
        } else {
          $flash->addFlash('failed changing server ip', 'warning');
        }
      }
      
      if (!empty($description) and $description != $server->getDescription()) {
        $success = $ticraft->call('updateServerDescription', array(
          $server->getId(),
          $description
        ));
        if ($success) {
          $flash->addFlash('success changing server desc', 'success');
        } else {
          $flash->addFlash('failed changing server desc', 'warning');
        }
      }
      
      if (!empty($type) and $type != $server->getServerType()->getId()) {
        $success = $ticraft->call('updateServerType', array(
          $server->getId(),
          $type
        ));
        if ($success) {
          $flash->addFlash('success changing server type', 'success');
        } else {
          $flash->addFlash('failed changing server type', 'warning');
        }
      }
      
      if (!empty($jsonapi_port) and $jsonapi_port != $server->getJsonapiPort()) {
        $success = $ticraft->call('updateServerJsonapiPort', array(
          $server->getId(),
          $jsonapi_port
        ));
        if ($success) {
          $flash->addFlash('success changing server port', 'success');
        } else {
          $flash->addFlash('failed changing server port', 'warning');
        }
      }
      
      if (!empty($jsonapi_username) and $jsonapi_username != $server->getJsonapiUsername()) {
        $success = $ticraft->call('updateServerJsonapiUsername', array(
          $server->getId(),
          $jsonapi_username
        ));
        if ($success) {
          $flash->addFlash('success changing server username', 'success');
        } else {
          $flash->addFlash('failed changing server username', 'warning');
        }
      }
      
      if (!empty($jsonapi_password) and $jsonapi_password != $server->getJsonapiPassword()) {
        $success = $ticraft->call('updateServerJsonapiPassword', array(
          $server->getId(),
          $jsonapi_password
        ));
        if ($success) {
          $flash->addFlash('success changing server password', 'success');
        } else {
          $flash->addFlash('failed changing server password', 'warning');
        }
      }
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'servers', $url);
      header('Location: ' . URL . '/' . $url);
      die();
    }
  } elseif (preg_match('#^add$#', $action)) {
    if (empty($_POST['server-name']) and empty($_POST['server-ip']) and empty($_POST['server-description']) and empty($_POST['server-type']) and empty($_POST['server-type']) and empty($_POST['server-jsonapi-port']) and empty($_POST['server-jsonapi-username']) and empty($_POST['server-jsonapi-password'])) {
      $types     = array();
      $all_types = $ticraft->call('getAllServerTypes');
      foreach ($all_types as $key => $value) {
        $types[] = new ServerType($value);
      }
      
      die($twig->render('admin/add_server.twig', array(
        'types' => $types,
        'page_title' => 'Add server',
        'user' => $user,
        'config' => $config,
        'flash' => new Flash
      )));
    } else {
      $name      = trim($_POST['server-name']);
      $ip       = trim($_POST['server-ip']);
      $description   = trim($_POST['server-description']);
      $type = intval($_POST['server-type']);
      $jsonapi_port      = intval($_POST['server-jsonapi-port']);
      $jsonapi_username = trim($_POST['server-jsonapi-username']);
      $jsonapi_password = trim($_POST['server-jsonapi-password']);
      
      $success = $ticraft->call('addServer', array(
        $name,
        $ip,
        $description,
        $type,
        $jsonapi_port,
        $jsonapi_username,
        $jsonapi_password
      ));
      
      $flash = new Flash;
      
      if ($success) {
        $flash->addFlash('success adding server', 'success');
      } else {
        $flash->addFlash('failed adding server', 'warning');
      }
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'servers', $url);
      header('Location: ' . URL . '/' . $url);
      die();
      
      
      
      
    }
  }
} elseif (!empty($_POST['remove-server'])) {
  $flash   = new Flash;
  $id      = intval($_POST['remove-server']);
  $success = $ticraft->call('removeServer', array(
    $id
  ));
  
  if ($success) {
    $flash->addFlash('success removing server', 'success');
  } else {
    $flash->addFlash('failed removing server', 'warning');
  }
  
  $url = $router->getController('manage')->getUrl();
  $url = preg_replace('#%m1%#', 'servers', $url);
  header('Location: ' . URL . '/' . $url);
  die();
} else {
  die($twig->render('admin/servers.twig', array(
    'manager' => new ServerManager($ticraft->call('getAllServers')),
    'page_title' => 'Manage servers',
    'user' => $user,
    'config' => $config,
    'flash' => new Flash
  )));
}