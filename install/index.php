<?php

if (!empty($_POST['username']) and !empty($_POST['key'])) {
  $username = $_POST['username'];
  $api_key  = $_POST['key'];
  
  try {
    $db = new PDO('sqlite:../app/config/database/minicraft.db');
    $db->exec('CREATE TABLE "Config" ("username" TEXT PRIMARY KEY, "api_key" TEXT, "session_expires" INTEGER, "cookie_expires" INTEGER)');
    $db->exec('CREATE TABLE "Bruteforce" ("id" INTEGER PRIMARY KEY AUTOINCREMENT, "action" TEXT, "ip" INTEGER, "attempts" INTEGER, "expires" INTEGER)');
    $db->exec('CREATE TABLE "Sessions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT, "user_id" INTEGER, "session_id" TEXT, "date_added" INTEGER, "date_expires" INTEGER)');
    $db->exec('CREATE TABLE "Cookies" ("id" INTEGER PRIMARY KEY AUTOINCREMENT, "user_id" INTEGER, "cookie_id" TEXT, "date_added" INTEGER, "date_expires" INTEGER)');
    $db->exec('CREATE TABLE "Emails" ("id" INTEGER PRIMARY KEY AUTOINCREMENT, "email" TEXT, "token" TEXT, "date_added" INTEGER, "date_confirmed" INTEGER)');
    $query = $db->prepare('INSERT INTO Config(username, api_key) VALUES(:username, :api_key)');
    $query->execute(array(
      'username' => $username,
      'api_key' => $api_key
    ));
    $db = null;
  }
  catch (PDOException $e) {
    die('<pre>' . $e->getMessage() . '</pre>');
  }
  
  header('Location: ../');
  die();
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Installation</title>
</head>
<body>
  <form method="post" action="">
    <label for="key">Username</label>
    <input type="text" name="username" id="username">
    <label for="key">API Key</label>
    <input type="text" name="key" id="key">
    <button type="submit">Save</button>
  </form>
</body>
</html>

<?php
}