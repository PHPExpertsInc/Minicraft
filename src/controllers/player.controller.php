<?php

/* ============================== */
$regex = $router->getController('player')->getRegex();
preg_match($regex, $uri, $matches);

$player_username = strip_tags($matches[1]);

$player_infos = $ticraft->call('getUserInfosFromUsername', array(
  $player_username
));

if (!empty($player_infos)) {
  $player = new User($player_infos);
  $manager      = new ServerManager($ticraft->call('getAllServers'));
  $server       = $manager->isPlaying($player->getMinecraftUsername());
}

if (!empty($server)) {
  $player_infos = $server->getPlayer($player->getMinecraftUsername());
} else {
  $player_infos = null;
}

$name = $player->getMinecraftUsername();
if (!empty($name)) {
  $title = $name;
} else {
  $title = $translator->getTranslation($config->getLang(), 'UNKNOWN_PLAYER');
}
/* ============================== */

/* ============================== */
die($twig->render('player/player.twig', array(
  'player' => $player,
  'playerInfos' => $player_infos,
  'manager' => $manager,
  'pageTitle' => $title,
  'user' => $user,
  'config' => $config,
  'flash' => new Flash
)));
/* ============================== */