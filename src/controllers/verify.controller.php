<?php

/* ============================== */
preg_match_all($router->getController('verify')->getRegex(), $uri, $matches);
$email = urldecode($matches[1][0]);
$token = $matches[2][0];
/* ============================== */

/* ============================== */
if (!empty($email) and !empty($token)) {
  $query = Database::getInstance()->prepare('SELECT token, date_confirmed FROM Emails WHERE email = :email');
  $query->execute(array(
    'email' => $email
  ));
  $fetch = $query->fetch();
  $query->closeCursor;
  
  /* ============================== */
  if (empty($fetch)) {
    Logger::log(__FILE__, 'Failed sending a confirmation email to ' . $email, 1);
  } elseif (is_numeric($fetch['date_confirmed']) and $fetch['date_confirmed'] != 0) {
    // Already confirmed
    die('already confirmed');
  } elseif ($token == $fetch['token']) {
    $query = Database::getInstance()->prepare('UPDATE Emails SET date_confirmed = :date_confirmed WHERE email = :email AND token = :token');
    $query->execute(array(
      'date_confirmed' => time(),
      'email' => $email,
      'token' => $token
    ));
    $query->closeCursor;
    
    $ticraft->call('confirmEmail', array(
      $email
    ));
    
    $flash = new Flash;
    $flash->addFlash('Votre adresse email a été confirmée.', 'success');
  } else {
    $flash = new Flash;
    $flash->addFlash('Token incorrect.', 'danger');
  }
  /* ============================== */
}
/* ============================== */

header('Location: ' . URL);
die();