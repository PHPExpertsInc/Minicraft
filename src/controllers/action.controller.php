<?php

/* ============================== */
if (!is_object($user) or $user->getRank()->getForce() < 100) {
  $message = 'A user tried to access the administration panel: ';
  $message .= is_object($user) ? $user->getUsername : 'Guest user';
  Logger::log(__FILE__, $message);
  Helpers::redirect($router, 'home');
  die();
}
/* ============================== */

/* ============================== */
$regex = $router->getController('action')->getRegex();
preg_match($regex, $uri, $matches);

$manage = $matches[1];
$action = $matches[2];
/* ============================== */

/* ============================== */
if (file_exists(BUNDLES . $manage . '/config/' . $manage . '.config.php')) {
  require_once(BUNDLES . $manage . '/config/' . $manage . '.config.php');
} elseif (file_exists(TEMPLATE_DIR . $manage . '.config.php')) {
  require_once(TEMPLATE_DIR . 'theme.config.php');
} elseif (file_exists(SOURCES . 'configs/' . $manage . '.config.php')) {
  require_once(SOURCES . 'configs/' . $manage . '.config.php');
} else {
  Helpers::throw404($twig, $config, $user);
}
/* ============================== */