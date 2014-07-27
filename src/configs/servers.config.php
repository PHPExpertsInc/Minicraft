<?php

$flash = new Flash;
if (!empty($action)) {
  if (preg_match('#^edit-server-(\d+)#', $action, $matches)) {
    $types     = array();
    $all_types = $ticraft->call('getAllServerTypes');
    foreach ($all_types as $server_type_infos) {
      if (!empty($server_type_infos)) {
        array_push($types, new ServerType($server_type_infos));
      }
    }
    $server_infos = $ticraft->call('getServerInfosFromId', $matches[1]);
    if (!empty($server_infos)) {
      $server = new Server($server_infos);
      if (empty($_POST)) {
        die($twig->render('admin/edit_server.twig', array(
          'server' => $server,
          'types' => $types,
          'pageTitle' => $translator->getTranslation($config->getLang(), 'EDIT_SERVER'),
          'user' => $user,
          'config' => $config,
          'flash' => $flash
        )));
      } else {
        $array = $_POST['edit-server'];
        $name             = trim($array['name']);
        $ip               = trim($array['ip']);
        $description      = trim($array['description']);
        $type             = intval($array['type']);
        $jsonapi_port     = intval($array['jsonapi-port']);
        $jsonapi_username = trim($array['jsonapi-username']);
        $jsonapi_password = trim($array['jsonapi-password']);
        
        if (!empty($name) and $name != $server->getName()) {
          $success = $ticraft->call('updateServerName', array(
            $server->getId(),
            $name
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_SERVER_NAME'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_SERVER_NAME'), 'warning');
          }
        }
        
        if (!empty($ip) and $ip != $server->getIp()) {
          $success = $ticraft->call('updateServerIp', array(
            $server->getId(),
            $ip
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_SERVER_IP'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_SERVER_IP'), 'warning');
          }
        }
        
        if (!empty($description) and $description != $server->getDescription()) {
          $success = $ticraft->call('updateServerDescription', array(
            $server->getId(),
            $description
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_SERVER_DESCRIPTION'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_SERVER_DESCRIPTION'), 'warning');
          }
        }
        
        if (!empty($type) and $type != $server->getServerType()->getId()) {
          $success = $ticraft->call('updateServerType', array(
            $server->getId(),
            $type
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_SERVER_TYPE'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_SERVER_TYPE'), 'warning');
          }
        }
        
        if (!empty($jsonapi_port) and $jsonapi_port != $server->getJsonapiPort()) {
          $success = $ticraft->call('updateServerJsonapiPort', array(
            $server->getId(),
            $jsonapi_port
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_JSONAPI_PORT'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_JSONAPI_PORT'), 'warning');
          }
        }
        
        if (!empty($jsonapi_username) and $jsonapi_username != $server->getJsonapiUsername()) {
          $success = $ticraft->call('updateServerJsonapiUsername', array(
            $server->getId(),
            $jsonapi_username
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_JSONAPI_USERNAME'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_JSONAPI_USERNAME'), 'warning');
          }
        }
        
        if (!empty($jsonapi_password) and $jsonapi_password != $server->getJsonapiPassword()) {
          $success = $ticraft->call('updateServerJsonapiPassword', array(
            $server->getId(),
            $jsonapi_password
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_JSONAPI_PASSWORD'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_JSONAPI_PASSWORD'), 'warning');
          }
        }
        
        Helpers::redirect($router, 'manage', array(
          'servers'
        ));
        die();
      }
    }
  } elseif (preg_match('#^add$#', $action)) {
    if (empty($_POST)) {
      $types     = array();
      $all_types = $ticraft->call('getAllServerTypes');
      foreach ($all_types as $server_type_infos) {
        if (!empty($server_type_infos)) {
          array_push($types, new ServerType($server_type_infos));
        }
      }
      
      die($twig->render('admin/add_server.twig', array(
        'types' => $types,
        'pageTitle' => $translator->getTranslation($config->getLang(), 'ADD_SERVER'),
        'user' => $user,
        'config' => $config,
        'flash' => $flash
      )));
    } else {
      $array = $_POST['add-server'];
      $name      = trim($array['name']);
      $ip       = trim($array['ip']);
      $description   = trim($array['description']);
      $type = intval($array['type']);
      $jsonapi_port      = intval($array['jsonapi-port']);
      $jsonapi_username = trim($array['jsonapi-username']);
      $jsonapi_password = trim($array['jsonapi-password']);
      
      $success = $ticraft->call('addServer', array(
        $name,
        $ip,
        $description,
        $type,
        $jsonapi_port,
        $jsonapi_username,
        $jsonapi_password
      ));
      
      if ($success) {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_ADD_SERVER'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_ADD_SERVER'), 'warning');
      }
      
      Helpers::redirect($router, 'manage', array(
        'servers'
      ));
      die();
    }
  }
} elseif (!empty($_POST['remove-server'])) {
  $id      = intval($_POST['remove-server']);
  $success = $ticraft->call('removeServer', array(
    $id
  ));
  
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_REMOVE_SERVER'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_REMOVE_SERVER'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'servers'
  ));
  die();
} else {
  die($twig->render('admin/servers.twig', array(
    'manager' => new ServerManager($ticraft->call('getAllServers')),
    'pageTitle' => $translator->getTranslation($config->getLang(), 'MANAGE_SERVERS'),
    'user' => $user,
    'config' => $config,
    'flash' => $flash
  )));
}