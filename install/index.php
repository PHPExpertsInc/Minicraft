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
  <meta charset="utf-8">
  <title>Ticraft Setup</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <style>
    body {
        background: url(//ticraft.fr/themes/ticraft/public/img/email_bg.jpg);
    }
    
    .jumbotron {
    	text-align: center;
    	width: 30rem;
    	border-radius: 0.5rem;
    	top: 0;
    	bottom: 0;
    	left: 0;
    	right: 0;
    	position: absolute;
    	margin: 4rem auto;
    	background-color: #fff;
    	padding: 2rem;
    }
    
    input {
    	width: 100%;
    	margin-bottom: 1.4rem;
    	padding: 1rem;
    	background-color: #ecf2f4;
    	border-radius: 0.2rem;
    	border: none;
    }
    
    h2 {
    	margin-bottom: 3rem;
    	font-weight: bold;
    	color: #ababab;
    }
    
    .btn {
    	border-radius: 0.2rem;
    	font-size: 3rem;
    	color: #fff;
    }
    
    .full-width {
    	background-color: #8eb5e2;
    	width: 100%;
    	-webkit-border-top-right-radius: 0;
    	-webkit-border-bottom-right-radius: 0;
    	-moz-border-radius-topright: 0;
    	-moz-border-radius-bottomright: 0;
    	border-top-right-radius: 0;
    	border-bottom-right-radius: 0;
    }
    
    .box {
    	position: absolute;
    	bottom: 0;
    	left: 0;
    	margin-bottom: 3rem;
    	margin-left: 3rem;
    	margin-right: 3rem;
    }
  </style>
</head>
<body>
  <div class="jumbotron">
    <div class="container">
      <span class="glyphicon glyphicon-list-alt"></span>
      <h2>Ticraft Setup</h2>
      <div class="box">
        <form method="post" action="">
          <input type="text" placeholder="Ticraft Username">
          <input type="text" placeholder="API Key">
          <button class="btn btn-default full-width" type="submit">GO</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
<?php
}