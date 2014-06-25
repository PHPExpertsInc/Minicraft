<?php

if (!empty($action)) {
  if (preg_match('#^edit-rank-(\d+)#', $action, $matches)) {
    $types     = array();
    $rank = new Rank($ticraft->call('getRankInfosFromId', $matches[1]));
    if (empty($_POST['rank-name']) and empty($_POST['rank-force'])) {
      die($twig->render('admin/edit_rank.twig', array(
        'rank' => $rank,
        'page_title' => 'Edit rank',
        'user' => $user,
        'config' => $config,
        'flash' => new Flash
      )));
    } else {
      $flash = new Flash;
      $name = trim($_POST['rank-name']);
      $force = intval($_POST['rank-force']);
      
      if (!empty($name) and $name != $rank->getName()) {
        $success = $ticraft->call('updateRankName', array(
          $rank->getId(),
          $name
        ));
        if ($success) {
          $flash->addFlash('success changing rank name', 'success');
        } else {
          $flash->addFlash('failed changing rank name', 'warning');
        }
      }
      
      if (!empty($force) and $force != $rank->getForce()) {
        $success = $ticraft->call('updateRankForce', array(
          $rank->getId(),
          $force
        ));
        if ($success) {
          $flash->addFlash('success changing rank force', 'success');
        } else {
          $flash->addFlash('failed changing rank force', 'warning');
        }
      }
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'ranks', $url);
      header('Location: ' . URL . '/' . $url);
      die();
    }
  } elseif (preg_match('#^add$#', $action)) {
    if (empty($_POST['rank-name']) and empty($_POST['rank-force'])) {      
      die($twig->render('admin/add_rank.twig', array(
        'page_title' => 'Add rank',
        'user' => $user,
        'config' => $config,
        'flash' => new Flash
      )));
    } else {
      $name      = trim($_POST['rank-name']);
      $force       = trim($_POST['rank-force']);
      
      $success = $ticraft->call('addRank', array(
        $name,
        $force
      ));
      
      $flash = new Flash;
      
      if ($success) {
        $flash->addFlash('success adding rank', 'success');
      } else {
        $flash->addFlash('failed adding rank', 'warning');
      }
      
      $url = $router->getController('manage')->getUrl();
      $url = preg_replace('#%m1%#', 'ranks', $url);
      header('Location: ' . URL . '/' . $url);
      die();
      
      
      
      
    }
  }
} elseif (!empty($_POST['remove-rank'])) {
  $flash   = new Flash;
  $id      = intval($_POST['remove-rank']);
  $success = $ticraft->call('removerank', array(
    $id
  ));
  
  if ($success) {
    $flash->addFlash('success removing rank', 'success');
  } else {
    $flash->addFlash('failed removing rank', 'warning');
  }
  
  $url = $router->getController('manage')->getUrl();
  $url = preg_replace('#%m1%#', 'ranks', $url);
  header('Location: ' . URL . '/' . $url);
  die();
} else {
  $ranks = array();
  $all_ranks = $ticraft->call('getAllRanks');
  foreach ($all_ranks as $key => $value) {
    $ranks[] = new Rank($value);
  }
  die($twig->render('admin/ranks.twig', array(
    'ranks' => $ranks,
    'page_title' => 'Manage ranks',
    'user' => $user,
    'config' => $config,
    'flash' => new Flash
  )));
}