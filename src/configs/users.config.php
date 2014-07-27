<?php

$flash = new Flash;

if (!empty($action)) {
  if (preg_match('#^edit-user-(\d+)#', $action, $matches)) {
    $types        = array();
    $player_infos = $ticraft->call('getUserInfosFromId', $matches[1]);
    if (!empty($player_infos)) {
      $player = new User($player_infos);
      if (empty($_POST)) {
        $ranks     = array();
        $all_ranks = $ticraft->call('getAllRanks');
        
        foreach ($all_ranks as $rank_infos) {
          if (!empty($rank_infos)) {
            array_push($ranks, new Rank($rank_infos));
          }
        }
        
        $countries = $translator->getCountries();
        
        die($twig->render('admin/edit_user.twig', array(
          'player' => $player,
          'ranks' => $ranks,
          'countries' => $countries,
          'pageTitle' => $translator->getTranslation($config->getLang(), 'EDIT_USER'),
          'user' => $user,
          'config' => $config,
          'flash' => $flash
        )));
      } else {
        $array              = $_POST['edit-player'];
        $username           = trim($array['username']);
        $email              = trim($array['email']);
        $money              = intval($array['money']);
        $rank_id            = intval($array['rank']);
        $minecraft_username = trim($_POST['minecraft-username']);
        $birthdate          = strtotime(trim($array['birthdate']));
        $genre              = trim($array['genre']);
        $country            = trim($array['country']);
        $city               = trim($array['city']);
        
        $error_handler = new ErrorHandler;
        $flash         = new Flash;
        
        if (!empty($username) and $username != $player->getUsername()) {
          if (!Helpers::usernameIsValid($username)) {
            $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'INVALID_USERNAME'), 'username');
            $error_handler->addError('username');
          } elseif (Helpers::tooShort($username, 3)) {
            $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'USERNAME_TOO_SHORT'), 'username');
            $error_handler->addError('username');
          } elseif (Helpers::tooLong($username, 255)) {
            $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'USERNAME_TOO_LONG'), 'username');
            $error_handler->addError('username');
          } elseif ($ticraft->call('usernameExists', array(
            $username
          ))) {
            $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'USERNAME_EXISTS'), 'username');
            $error_handler->addError('username');
          } else {
            $success = $ticraft->call('updateUsername', array(
              $player->getId(),
              $player->getUsername(),
              $username
            ));
            if ($success) {
              $player->setUsername($username);
              $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_USERNAME'), 'success');
            } else {
              $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_USERNAME'), 'warning');
            }
          }
        }
        
        if (!empty($email) and $email != $player->getEmail()) {
          if (!Helpers::emailIsValid($email)) {
            $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'EMAIL_INVALID'), 'email');
            $error_handler->addError('email');
          } elseif ($ticraft->call('emailExists', array(
            $email
          ))) {
            $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'EMAIL_EXISTS'), 'email');
            $error_handler->addError('email');
          } else {
            $success = $ticraft->call('updateEmail', array(
              $player->getId(),
              $player->getEmail(),
              $email,
              Database::emailAlreadyConfirmed($email)
            ));
            $result  = Database::addEmail($email, $player->getUsername());
            if ($success) {
              if ($result === true) { // Email already confirmed
                $player->setEmail($email);
                $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_EMAIL'), 'success');
              } else {
                Email::sendConfirmationEmail($email, $player->getUsername(), $result, $translator, $config, $router);
                $flash->addFlash($translator->getTranslation($config->getLang(), 'EMAIL_SENT_CONFIRM_EMAIL', array(
                  $email
                )), 'info');
              }
            } else {
              $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_EMAIL'), 'warning');
            }
          }
        }
        
        if (!empty($money) and $money != $player->getMoney()) {
          $success = $ticraft->call('updateMoney', array(
            $player->getId(),
            abs($money)
          ));
          
          if ($success) {
            $player->setMoney($money);
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_MONEY'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_MONEY'), 'warning');
          }
        }
        
        if (!empty($rank_id) and $rank_id != $player->getRank()->getId()) {
          $success = $ticraft->call('updateRank', array(
            $player->getId(),
            $rank_id
          ));
          
          if ($success) {
            $rank_infos = $ticraft->call('getRankInfosFromId', array(
              $rank_id
            ));
            if (!empty($rank_infos)) {
              $player->setRank(new Rank($rank_infos));
            }
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_RANK'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_RANK'), 'warning');
          }
        }
        
        if (!empty($genre) and $genre != $player->getGenre()) {
          if (!in_array($genre, array(
            'unspecified',
            'female',
            'male'
          ))) {
            $error_handler->addErrorMessage($translator->getTranslation($config->getLang(), 'GENRE_INCORRECT'), 'genre');
            $error_handler->addError('genre');
          } else {
            $success = $ticraft->call('updateGenre', array(
              $player->getId(),
              $genre
            ));
            if ($success) {
              $player->setGenre($genre);
              $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_GENRE'), 'success');
            } else {
              $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_GENRE'), 'warning');
            }
          }
        }
        
        if ($birthdate != $player->getBirthdate() and is_numeric($birthdate)) {
          $success = $ticraft->call('updateBirthdate', array(
            $player->getId(),
            $birthdate
          ));
          if ($success) {
            $player->setBirthdate($birthdate);
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_BIRTHDATE'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_BIRTHDATE'), 'warning');
          }
        }
        
        if (!empty($country) and $country != $player->getCountry()) {
          $success = $ticraft->call('updateCountry', array(
            $player->getId(),
            $country
          ));
          if ($success) {
            $player->setCountry($country);
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_COUNTRY'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_COUNTRY'), 'warning');
          }
        }
        
        if ($city != $player->getCity()) {
          $success = $ticraft->call('updateCity', array(
            $player->getId(),
            $city
          ));
          if ($success) {
            $player->setCity($city);
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_UPDATE_CITY'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_UPDATE_CITY'), 'warning');
          }
        }
      }
      
      Helpers::redirect($router, 'manage', array(
        'users'
      ));
      die();
    }
  }
} elseif (!empty($_POST['confirm-email'])) {
  $user_id = intval($_POST['confirm-email']);
  
  $user_infos = $ticraft->call('getUserInfosFromId', array(
    $user_id
  ));
  
  if (!empty($user_infos)) {
    $player = new User($user_infos);
    
    $success = $ticraft->call('confirmEmail', array(
      $player->getEmail()
    ));
  }
  
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CONFIRM_EMAIL'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CONFIRM_EMAIL'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'users'
  ));
  die();
} elseif (!empty($_POST['reset-password'])) {
  $user_id = intval($_POST['reset-password']);
  
  $user_infos = $ticraft->call('getUserInfosFromId', array(
    $user_id
  ));
  
  if (!empty($user_infos)) {
    // Using $player instead of $user to prevent conflict with the personn logged which should be $user
    $player = new User($user_infos);
    
    $token = $ticraft->call('generateResetToken', array(
      $player->getId()
    ));
    
    Email::sendResetPasswordEmail($player->getEmail(), $player->getUsername(), $token, $translator, $config, $router);
    
    $success = true;
  }
  
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_RESET_PASSWORD'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_RESET_PASSWORD'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'users'
  ));
  die();
} elseif (!empty($_POST['ban-user'])) {
  $array         = $_POST['ban-user'];
  $duration      = $array['duration'];
  $duration_type = $array['duration-type'];
  $ban_in_game   = !empty($array['ban-in-game']);
  $reason        = trim($array['reason']);
  $user_id       = $array['id'];
  
  $seconds = $duration * $duration_type;
  
  $success = $ticraft->call('banUser', array(
    $user_id,
    $seconds,
    $reason
  ));
  
  if ($ban_in_game) {
    $manager = new ServerManager($ticraft->call('getAllServers'));
    $player  = new User($ticraft->call('getUserInfosFromId', array(
      $user_id
    )));
    
    foreach ($manager->getServers() as $server) {
      $server->banPlayer($player->getMinecraftUsername(), $reason);
    }
  }
  
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_BAN_USER', time() + $seconds), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_BAN_USER'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'users'
  ));
  die();
} else {
  $users     = array();
  $all_users = $ticraft->call('getAllUsers');
  if (!empty($all_users)) {
    foreach ($all_users as $user_infos) {
      if (!empty($user_infos)) {
        array_push($users, new User($user_infos));
      }
    }
  }
  die($twig->render('admin/users.twig', array(
    'users' => $users,
    'page_title' => $translator->getTranslation($config->getLang(), 'MANAGE_USERS'),
    'user' => $user,
    'config' => $config,
    'flash' => $flash
  )));
}