<?php

$flash = new Flash;
if (!empty($action)) {
  if (preg_match('#^edit-rank-(\d+)#', $action, $matches)) {
    $types     = array();
    $rank_infos = $ticraft->call('getRankInfosFromId', $matches[1]);
    if (!empty($rank_infos)) {
      $rank = new Rank($rank_infos);
      if (empty($_POST)) {
        die($twig->render('admin/edit_rank.twig', array(
          'rank' => $rank,
          'pageTitle' => $translator->getTranslation($config->getLang(), 'EDIT_RANK'),
          'user' => $user,
          'config' => $config,
          'flash' => $flash
        )));
      } else {
        $array = $_POST['edit-rank'];
        $name = trim($array['name']);
        $force = intval($array['force']);
        
        if (!empty($name) and $name != $rank->getName()) {
          $success = $ticraft->call('updateRankName', array(
            $rank->getId(),
            $name
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_RANK_NAME'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_RANK_NAME'), 'warning');
          }
        }
        
        if (!empty($force) and $force != $rank->getForce()) {
          $success = $ticraft->call('updateRankForce', array(
            $rank->getId(),
            $force
          ));
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_RANK_FORCE'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_RANK_FORCE'), 'warning');
          }
        }
        
        Helpers::redirect($router, 'manage', array(
          'ranks'
        ));
        die();
      }
    }
  } elseif (preg_match('#^add$#', $action)) {
    if (empty($_POST)) {      
      die($twig->render('admin/add_rank.twig', array(
        'pageTitle' => $translator->getTranslation($config->getLang(), 'ADD_RANK'),
        'user' => $user,
        'config' => $config,
        'flash' => $flash
      )));
    } else {
      $array = $_POST['add-rank'];
      $name      = trim($array['name']);
      $force       = trim($array['force']);
      
      $success = $ticraft->call('addRank', array(
        $name,
        $force
      ));
      
      if ($success) {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_ADD_RANK'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_ADD_RANK'), 'warning');
      }
      
      Helpers::redirect($router, 'manage', array(
        'ranks'
      ));
      die();
    }
  }
} elseif (!empty($_POST['remove-rank'])) {
  $id      = intval($_POST['remove-rank']);
  $success = $ticraft->call('removerank', array(
    $id
  ));
  
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_REMOVE_RANK'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_REMOVE_RANK'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'ranks'
  ));
  die();
} else {
  $ranks = array();
  $all_ranks = $ticraft->call('getAllRanks');
  foreach ($all_ranks as $rank_infos) {
    if (!empty($rank_infos)) {
      array_push($ranks, new Rank($rank_infos));
    }
  }
  die($twig->render('admin/ranks.twig', array(
    'ranks' => $ranks,
    'pageTitle' => $translator->getTranslation($config->getLang(), 'MANAGE_RANKS'),
    'user' => $user,
    'config' => $config,
    'flash' => $flash
  )));
}