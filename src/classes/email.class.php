<?php

class Email {
  public static function getBackgroundUrl($router) {
    $background_url = 'http:' . URL . '/' . $router->getController('assets')->getUrl();
    $background_url = preg_replace('#%m1%#', 'img/email_bg.png', $background_url);
    
    return $background_url;
  }

  public static function sendConfirmationEmail($email, $username, $token, $translator, $config, $router) {
    $swift_class = VENDORS . 'Swift/swift_required.php';
    require_once($swift_class);
    
    $verify_url = 'http:' . URL . '/' . $router->getController('verify')->getUrl();
    $verify_url = preg_replace('#%m1%#', urlencode($email), $verify_url);
    $verify_url = preg_replace('#%m2%#', $token, $verify_url);
    
    $infos = array(
      'subject' => $translator->getTranslation($config->getLang(), 'EMAIL_CONFIRMATION_SUBJECT'),
      'username' => ucfirst($username),
      'siteName' => ucfirst($config->getSiteName()),
      'siteEmail' => $config->getSiteEmail(),
      'verifyUrl' => $verify_url,
      'backgroundUrl' => self::getBackgroundUrl($router),
      'activateBtn' => $translator->getTranslation($config->getLang(), 'EMAIL_CONFIRMATION_BTN'),
      'instructions' => $translator->getTranslation($config->getLang(), 'EMAIL_CONFIRMATION_INSTRUCTIONS'),
      'headline' => $translator->getTranslation($config->getLang(), 'EMAIL_CONFIRMATION_HEADLINE')
    );
    
    $body     = self::formatConfirmationEmail($infos, 'html');
    $body_txt = self::formatConfirmationEmail($infos, 'txt');
    
    $smtp = $config->getSmtpServer();
    if (!empty($smtp)) {
      $transport = Swift_SmtpTransport::newInstance($config->getSmtpServer(), $config->getSmtpPort())->setUsername($config->getSmtpUsername())->setPassword($config->getSmtpPassword());
    } else {
      $transport = Swift_SmtpTransport::newInstance('127.0.0.1', 25);
    }
    
    $mailer  = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance();
    
    $message->setSubject($infos['subject']);
    $message->setFrom(array(
      $config->getSiteEmail() => $config->getSiteName()
    ));
    $message->setTo(array(
      $email => ucfirst($username)
    ));
    
    $message->setBody($body_txt);
    $message->addPart($body, 'text/html');
    
    // Sending
    $result = $mailer->send($message);
    
    return $result;
  }
  
  protected static function formatConfirmationEmail($infos, $format) {
    Twig_Autoloader::register();
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(EMAIL_TEMPLATES));
    
    $template = $twig->render('confirmation/' . $format . '_template.twig', array(
      'infos' => $infos
    ));
    
    return $template;
  }
  
  public static function sendResetPasswordEmail($email, $username, $token, $translator, $config, $router) {
    $swift_class = VENDORS . 'Swift/swift_required.php';
    require_once($swift_class);
    
    $reset_url = 'http:' . URL . '/' . $router->getController('reset')->getUrl() . '?token=' . $token;
    
    $infos = array(
      'subject' => $translator->getTranslation($config->getLang(), 'EMAIL_RESET_SUBJECT'),
      'username' => ucfirst($username),
      'resetUrl' => $reset_url,
      'backgroundUrl' => self::getBackgroundUrl($router),
      'btn' => $translator->getTranslation($config->getLang(), 'EMAIL_RESET_BTN'),
      'instructions' => $translator->getTranslation($config->getLang(), 'EMAIL_RESET_INSTRUCTIONS'),
      'inscructions_txt' => $translator->getTranslation($config->getLang(), 'EMAIL_RESET_INSTRUCTIONS_TXT'),
      'headline' => $translator->getTranslation($config->getLang(), 'EMAIL_RESET_HEADLINE')
    );
    
    $body     = self::formatResetPasswordEmail($infos, $config, 'html');
    $body_txt = self::formatResetPasswordEmail($infos, $config, 'txt');
    
    $smtp = $config->getSmtpServer();
    if (!empty($smtp)) {
      $transport = Swift_SmtpTransport::newInstance($config->getSmtpServer(), $config->getSmtpPort())->setUsername($config->getSmtpUsername())->setPassword($config->getSmtpPassword());
    } else {
      $transport = Swift_SmtpTransport::newInstance('127.0.0.1', 25);
    }
    
    $mailer  = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance();
    
    $message->setSubject($infos['subject']);
    $message->setFrom(array(
      $config->getSiteEmail() => $config->getSiteName()
    ));
    $message->setTo(array(
      $email => ucfirst($username)
    ));
    
    $message->setBody($body_txt);
    $message->addPart($body, 'text/html');
    
    // Sending
    $result = $mailer->send($message);
    
    return $result;
  }
  
  protected static function formatResetPasswordEmail($infos, $config, $format) {
    Twig_Autoloader::register();
    $twig = new Twig_Environment(new Twig_Loader_Filesystem(EMAIL_TEMPLATES));
    
    $template = $twig->render('reset/' . $format . '_template.twig', array(
      'infos' => $infos,
      'config' => $config
    ));
    
    return $template;
  }
}
