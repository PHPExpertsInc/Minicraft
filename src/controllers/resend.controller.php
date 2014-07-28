<?php

/* ============================== */
if (Security::userCanDoAction('resend', false)) {
  if (is_object($user) and !$user->getConfirmed()) {
    $flash = new Flash;
    $token = Database::addEmail($user->getEmail(), $user->getUsername());
    Email::sendConfirmationEmail($user->getEmail(), $user->getUsername(), $token, $translator, $config, $router);
    $flash->addFlash($translator->getTranslation($config->getLang(), 'CONFIRMATION_LINK_SENT', array($user->getEmail())), 'info');
    Security::actionSucceeded('resend');
  }
} else {
  Security::actionFailed('resend');
}
/* ============================== */

Helpers::redirect($router, 'index');
die();