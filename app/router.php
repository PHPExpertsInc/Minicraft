<?php

/**
 * #######################################
 * # _____                _              #
 * #|  __ \              | |             #
 * #| |__) | ___   _   _ | |_  ___  _ __ #
 * #|  _  / / _ \ | | | || __|/ _ \| '__|#
 * #| | \ \| (_) || |_| || |_|  __/| |   #
 * #|_|  \_\\___/  \____| \__|\___||_|   #
 * #######################################
 */

$uri = $_SERVER['REQUEST_URI'];

if ($uri == '/forum/') {
  header('Location: ' . URL . '/forum/');
  die();
}

foreach ($router->getControllers() as $controller) {
  if (preg_match($controller->getRegex(), $uri)) {
    if (file_exists(BUNDLES . $controller->getBundle() . '/controllers/' . $controller->getName() . '.controller.php')) {
      $require = BUNDLES . $controller->getBundle() . '/controllers/' . $controller->getName() . '.controller.php';
    } else {
      $require = CONTROLLERS . $controller->getName() . '.controller.php';
    }
    break;
  }
}

if (!empty($require) and file_exists($require)) {
  require_once($require);
} else {
  Helpers::throw404($twig, $config, $user);
  die();
}
