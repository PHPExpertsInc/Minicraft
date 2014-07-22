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
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
  <style>
    body {
      background-color: #f5f8fa;
      font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
       font-weight: normal;
       padding-bottom: 15px;
    }
    
    input {
      border: none !important;
      height: 8rem !important;
      margin-bottom: 2rem !important;
      font-size: 4.5rem !important;
      text-align: center;
      color: #556270 !important;
      border-radius: 3px !important;
    }
    
    @media (max-width: 480px) {
      input {
        font-size: 2.5rem !important;
      }
    }
    
    input:focus {
      box-shadow: none !important;
    }
    
    .box {
      margin-top: 10%;
      padding: 2rem;
      background-color: #556270;
      text-align: center;
      border-radius: 6px;
    }
    
    @media (max-width: 768px) {
      .box {
        margin-top: 15px;
      }
    }
    
    .btn-success {
      border: none;
      border-radius: 3px;
      background-color: #c7f464;
      color: #556270;
      height: 8rem;
    }
    
    .btn-success:hover {
      background-color: #c7f464;
      color: #556270;
    }
    
    ::-webkit-input-placeholder {
       color: #a5acb5 !important;
       opacity: 1 !important;
    }
    
    :-moz-placeholder {
       color: #a5acb5 !important;
       opacity: 1 !important;
    }
    
    ::-moz-placeholder {
       color: #a5acb5 !important;
       opacity: 1 !important;
    }
    
    :-ms-input-placeholder {  
       color: #a5acb5 !important;
       opacity: 1 !important;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-offset-3 col-md-6">
        <div class="box">
          <form method="post" action="">
            <div class="form-group">
              <input id="username" class="form-control input-lg" type="text" name="username" placeholder="Ticraft Username">
            </div>
            <div class="form-group">
              <input id="key" class="form-control input-lg" type="text" name="key" placeholder="API Key">
            </div>
            <button type="submit" class="btn btn-success btn-block btn-lg"><i class="fa fa-check fa-3x"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="//raw.githubusercontent.com/mathiasbynens/jquery-placeholder/master/jquery.placeholder.js"></script>
  <script>
    $('input').placeholder();
  </script>
</body>
</html>
<?php
}