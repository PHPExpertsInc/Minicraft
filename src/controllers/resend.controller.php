<?php

/* ============================== */
if (Security::userCanDoAction('resend', false)) {
  if (is_object($user) and !$user->getConfirmed()) {
    $flash = new Flash;
    $token = Database::addEmail($user->getEmail(), $user->getUsername());
    Email::sendConfirmationEmail($user->getEmail(), $user->getUsername(), $token);
    $flash->addFlash('Un lien a été envoyé à ' . $user->getEmail() . ' pour confirmer cette adresse email.', 'info');
    Security::actionSucceeded('resend');
  }
} else {
  Security::actionFailed('resend');
}
/* ============================== */

header('Location: ' . URL);
die();