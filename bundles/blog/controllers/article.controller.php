<?php

$regex = $router->getController('article')->getRegex();
preg_match($regex, $uri, $matches);

$article_id   = $matches[1];
$article_slug = $matches[2];

$article = new Article($ticraft->call('getArticleInfosFromId', array(
  $article_id
)));

if (empty($article)) {
  Helpers::throw404($twig, $config, $user);
  die();
} elseif ($article_slug != $article->getSlug()) {
  Helpers::redirect($router, 'article', array(
    $article->getId(),
    $article->getSlug()
  ));
  die();
} else {
  die($blog_twig->render('article.twig', array(
    'manager' => new ServerManager($ticraft->call('getAllServers')),
    'article' => $article,
    'pageTitle' => Helpers::generateExtract($article->getTitle(), 32),
    'config' => $config,
    'user' => $user,
    'flash' => new Flash
  )));
}