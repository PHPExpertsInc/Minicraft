<?php

/* ============================== */
$regex = $router->getController('player')->getRegex();
preg_match($regex, $uri, $matches);

$player_username = strip_tags($matches[1]);

$player = new User($ticraft->call('getUserInfosFromUsername', array(
  $player_username
)));

$manager      = new ServerManager($ticraft->call('getAllServers'));
$server       = $manager->isPlaying($player->getMinecraftUsername());

if (!empty($server)) {
  $player_infos = $server->getPlayer($player_username);
}
/* ============================== */

/* ============================== */
die($twig->render('player/player.twig', array(
  'player' => $player,
  'playerInfos' => $player_infos,
  'manager' => $manager,
  'pagePitle' => $player_username,
  'user' => $user,
  'config' => $config,
  'flash' => new Flash
)));
/* ============================== */