<?php

die($twig->render('index/index.twig', array(
  'manager' => new ServerManager($ticraft->call('getAllServers')),
  'blog' => new Blog($ticraft->call('getAllArticlesAndAllArticleCategories')),
  'pageTitle' => $translator->getTranslation($config->getLang(), 'HOME'),
  'config' => $config,
  'user' => $user,
  'flash' => new Flash
)));