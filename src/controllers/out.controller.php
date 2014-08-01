<?php

$regex = $router->getController('out')->getRegex();
preg_match($regex, $uri, $matches);

$link = $matches[1];

if (!filter_var($link, FILTER_VALIDATE_URL)) {
  $link = URL . '/' . $link;
}

if (!is_object($user)) {
  header('Location: ' . $link);
  die();
} else {
  $ticraft->call('userClickedVoteLink', $user->getId());
  header('Location: ' . $link);
  die();
}