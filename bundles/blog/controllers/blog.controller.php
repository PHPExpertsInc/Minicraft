<?php

die($blog_twig->render('blog.twig', array(
  'manager' => new ServerManager($ticraft->call('getAllServers')),
  'blog' => new Blog($ticraft->call('getAllArticlesAndAllArticleCategories')),
  'pageTitle' => $translator->getTranslation($config->getLang(), 'BLOG'),
  'config' => $config,
  'user' => $user,
  'flash' => new Flash
)));