<?php

/* ============================== */
$regex = $router->getController('assets')->getRegex();
preg_match($regex, $uri, $matches);

$filepath = $matches[1];
$path = PUBLIC_FILES . $filepath;
/* ============================== */

/* ============================== */
if (file_exists($path)) {
  header('Location: ' . URL . '/' . $path);
  die();
} else {
  Helpers::throw404($twig, $config, $user);
}
/* ============================== */