<?php
  session_start();
  include "connexion/config.php";
  if(isset($_POST['submit'])){
    $username = filter_var(htmlentities($_POST['user']),FILTER_SANITIZE_STRING);
    $password = filter_var(htmlentities(md5($_POST['mdps']),FILTER_SANITIZE_STRING));

    $loginsql = "SELECT * FROM utilisateur WHERE NOMUTILISATEUR = :user  AND MOTDEPASSE = :mdps";
    $query = $conn->prepare($loginsql);
    $query->bindParam(':user', $username, PDO::PARAM_STR);
    $query->bindParam(':mdps', $password, PDO::PARAM_STR);
    $query->execute();
    $num = $query->rowCount();
    if($username==null || $password==null){
      echo "<div class='alert alert-danger almessage' role='alert'>
      Veuillez entrer le nom d'utilisateur et le mot de passe!
      </div>";
  }elseif($num == 0){
        echo "<div class='alert alert-danger almessage' role='alert'>
              Le nom d'utilisateur ou le mot de passe est incorrect!
              </div>";
    }else{
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['idC']=$row['IDCOMPTE'];
        $_SESSION['user']=$row['NOMUTILISATEUR'];
        $_SESSION['typeC']=$row['TYPECOMPTE'];
        
      }
      header('location:pageAcc.php');
    }


  }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GBO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="css/loginStyle.css">
</head>

<body>
    <div class="login-clean">
        <form method="post" action="">
            <h2 class="sr-only"></h2>
            <div class="illustration"><img src="image/logo.png"alt=""></div>
            <div class="form-group"><input class="form-control" type="text" name="user" placeholder="Nom d'utilisateur"></div>
            <div class="form-group"><input class="form-control" type="password" name="mdps" placeholder="Mot de passe"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" name="submit" type="submit">Se Connecter</button></div></form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>