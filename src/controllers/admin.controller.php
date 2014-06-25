<?php

/* ============================== */
if (!is_object($user) or $user->getRank()->getForce() < 100) {
  $message = 'A user tried to access the administration panel: ';
  $message .= is_object($user) ? $user->getUsername : 'Guest user';
  Logger::log(__FILE__, $message);
  header('Location: ' . URL);
  die();
}
/* ============================== */

die($twig->render('admin/admin.twig', array(
  'pageTitle' => $translator->getTranslation($config->getLanguage(), 'ADMIN_PANEL'),
  'manager' => new ServerManager($ticraft->call('getAllServers')),
  'user' => $user,
  'config' => $config,
  'flash' => new Flash
)));