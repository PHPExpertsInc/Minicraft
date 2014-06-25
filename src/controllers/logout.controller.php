<?php

/* ============================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Security::logOut();
  if (!empty($_POST['logout']['from'])) {
    header('Location: ' . $_POST['logout']['from']);
    die();
  }
}
/* ============================== */

header('Location: ' . URL);
die();