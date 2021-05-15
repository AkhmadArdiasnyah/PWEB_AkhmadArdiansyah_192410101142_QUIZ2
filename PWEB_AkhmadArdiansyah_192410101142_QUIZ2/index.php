<?php
    session_start();

    $db = new PDO(
      'mysql:host=localhost;dbname=akunardi',
      'root'
    );

    if ( isset($_COOKIE["id"]) && isset($_COOKIE["username"]) ) {
      $data = $db->prepare("SELECT username FROM login WHERE id=?");
      $data->execute([$_COOKIE["id"]]);
      $row = $data->fetch();

      if ( $_COOKIE["username"] === hash("md5", $row["username"]) ) {
        $_SESSION["login"] = true;
      }
    }

    if ( isset($_SESSION["login"]) ) {
      header("Location: home.php");
      exit;
    }

    if ( isset($_POST['submit']) ) {
      $data = $db->prepare("SELECT * FROM login WHERE username=? AND password=?");
      $data->execute([$_POST['username'], $_POST['password']]);
      $count = $data->rowCount();
      $row = $data->fetch();
      if ( $count === 1 ) {
        $_SESSION["login"] = true;

        if ( isset($_POST["remember"]) ) {
          setcookie('id', $row['id'], time()+700);
          setcookie('username', hash("md5", $row['username']), time()+700);
        }

        header("Location: home.php");
        exit;
      }
    }
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <title>Tugas PWEB</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
    <div class="container mt-3 shadow-lg p-3 mb-5 bg-dark rounded">
        <h1 style="text-align:center;">Tugas PemroWeb ( Login Form With Session Cookies )</h1>
        <br></br>
        <div class="mx-auto" style="width: 200px;">
<form action="" method="post" id="frmLogin" >
<div class="login-box"  style="color:black">
  <h1>Login</h1>
  <div class="textbox" >
    <i class="fas fa-user"></i>
    <input type="text" name="username" placeholder="Username" style="color:black">
  </div>

  <div class="textbox">
    <i class="fas fa-lock"></i>
    <input type="password" name="password" placeholder="Password" style="color:black">
  </div>
  <div class="field-group">
		<div><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> />
		<label for="remember-me">Remember me</label>
	</div>
  <h5>username ,password : ardi</h5>
  <input type="submit" class="btn" name="submit" value="Submit" style="color:black">
</div>
</form>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
 </body>
</html>