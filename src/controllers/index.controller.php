<?php

$server = $ticraft->call('getAllServers');
if (empty($server)) {
  Helpers::redirect($router, 'action', array(
    'servers',
    'add'
  ));
  die();
}

die($twig->render('index/index.twig', array(
  'manager' => new ServerManager($servers),
  'blog' => new Blog($ticraft->call('getAllArticlesAndAllArticleCategories')),
  'pageTitle' => $translator->getTranslation($config->getLang(), 'HOME'),
  'config' => $config,
  'user' => $user,
  'flash' => new Flash
)));