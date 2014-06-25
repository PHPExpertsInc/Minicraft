<?php

die($twig->render('index/index.twig', array(
  'manager' => new ServerManager($ticraft->call('getAllServers')),
  'blog' => new Blog($ticraft->call('getAllArticlesAndAllCategories')),
  'title' => 'Accueil',
  'config' => $config,
  'user' => $user,
  'flash' => new Flash
)));