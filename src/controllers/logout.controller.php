<?php

/* ============================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Security::logOut();
  if (!empty($_POST['logout']['from'])) {
    header('Location: ' . $_POST['logout']['from']);
    die();
  } elseif (!empty($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
  }
}
/* ============================== */

Helpers::redirect($router, 'home');
die();