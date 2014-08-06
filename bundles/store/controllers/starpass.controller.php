<?php

if (!is_object($user)) {
  $flash = new Flash;
  $flash->addFlash($translator->getTranslation($config->getLang(), 'SIGN_IN_TO_BUY'), 'info');
  Helpers::redirect($router, 'store');
  die();
} elseif (empty($_POST)) {
  die($store_twig->render('starpass.twig', array(
    'pageTitle' => $translator->getTranslation($config->getLang(), 'PURCHASE_MONEY'),
    'config' => $config,
    'user' => $user,
    'flash' => $flash
  )));
} else {
  $ident = $idp = $ids = $idd = $codes = $code1 = $code2 = $code3 = $code4 = $code5 = $datas = '';
  
  $infos = $config->getStarpassInfos();
  $idp   = $infos['idp'];
  $idd   = $infos['idd'];
  $ident = $idp . ';' . $ids . ';' . $idd;
  
  if (isset($_POST['code1']))
    $code1 = $_POST['code1'];
  if (isset($_POST['code2']))
    $code2 = ';' . $_POST['code2'];
  if (isset($_POST['code3']))
    $code3 = ';' . $_POST['code3'];
  if (isset($_POST['code4']))
    $code4 = ';' . $_POST['code4'];
  if (isset($_POST['code5']))
    $code5 = ';' . $_POST['code5'];
  $codes = $code1 . $code2 . $code3 . $code4 . $code5;
  
  if (isset($_POST['DATAS']))
    $datas = $_POST['DATAS'];
  
  $ident = urlencode($ident);
  $codes = urlencode($codes);
  $datas = urlencode($datas);
  
  /* Envoi de la requête vers le serveur StarPass
  Dans la variable tab[0] on récupère la réponse du serveur
  Dans la variable tab[1] on récupère l'URL d'accès ou d'erreur suivant la réponse du serveur */
  
  $get_f = @file('http://script.starpass.fr/check_php.php?ident=' . $ident . '&codes=' . $codes . '&DATAS=' . $datas);
  
  if (!$get_f) {
    die('Votre serveur n\'a pas accès au serveur de StarPass, merci de contacter votre hébergeur.');
  }
  
  $tab = explode("|", $get_f[0]);
  
  // dans $pays on a le pays de l'offre. exemple "fr"
  $pays      = $tab[2];
  // dans $palier on a le palier de l'offre. exemple "Plus A"
  $palier    = urldecode($tab[3]);
  // dans $id_palier on a l'identifiant de l'offre
  $id_palier = urldecode($tab[4]);
  // dans $type on a le type de l'offre. exemple "sms", "audiotel, "cb", etc.
  $type      = urldecode($tab[5]);
  // vous pouvez à tout moment consulter la liste des paliers à l'adresse : http://script.starpass.fr/palier.php
  
  // Si $tab[0] ne répond pas "OUI" l'accès est refusé
  // On redirige sur l'URL d'erreur
  $flash = new Flash;
  if (substr($tab[0], 0, 3) != 'OUI') {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'ERROR_STARPASS'), 'warning');
  } else {
    $success = $ticraft->call('userPurchasedMoney', array(
      $user->getId(),
      $config->getMoneyAddedPerCode(),
      $ident,
      $codes,
      $data
    ));
    
    $sum = $config->getMoneyAddedPerCode();
    $temp = $config->getCurrencyName();
    $currency = $sum > 1 ? $temp['plural'] : $temp['singular'];
    
    if ($success) {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_BUY_MONEY', array($sum, $currency)), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_BUY_MONEY'), 'warning');
    }
  }
  
  Helpers::redirect($router, 'store');
  die();
}