<?php

  session_start();

  if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {
    header('Location: index.php');
    exit();
  }

  if(isset($_POST['post_me']) || isset($_POST['post_form'])) {

  require_once "connect.php";

  if(isset($_POST['login']) && !empty($_POST['login'])) {

  //Pobieranie danych
  $nick = $_POST['login'];
  $haslo = $_POST['haslo'];

  $rezultat = mysqli_query($polaczenie, "SELECT * FROM uzytkownicy WHERE user='$nick' && haslo='$haslo'") or die ("Blad zapytania");

  $ile_takich_user = $rezultat->num_rows;
  if($ile_takich_user>0)
  {
    while($row = mysqli_fetch_assoc($rezultat)) {
      $_SESSION['zalogowany'] = true;
      $_SESSION['id'] = $row['id_user'];
      $_SESSION['user'] = $row['user'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['group_id'] = $row['grupa'];
      if(isset($_GET['continue'])) {
        header('Location: oferty/zamow.php?id='.$_GET['continue']);
      } else {
        header('Location: index.php');
      }
    }
    $rezultat->free_result();
  } else {
    $error = true;
  }
} else {
  $error = true;
}
}

 ?>

<!--
 <!DOCTYPE HTML>
 <head>
   <title>Biuro podróży - rejestracja</title>
   <meta charset="UTF-8">
   <link href="styles/main.css" rel="stylesheet" type="text/css">
 </head>
 <body>

   <form class="register" method="post">
     Login: <input type="text" name="login">
     Hasło: <input type="password" name="haslo">
     <input type="submit" value="logowanie">
   </form>

</body>
-->



   <!DOCTYPE HTML>
   <html>
   <head>
     <title>Biuro podróży</title>
     <meta charset="UTF-8">
     <link href="styles/main.css" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
   </head>
   <body style="height:100%;overflow: hidden">


  <div style="float: left;
      margin-left: 30px;
      background: #fff;
      width: 170px;
      height: 35px;
      margin-top: 17.5px;
      background-size: cover;"></div>

  <div class="nav" style="line-height:95px;position:relative;z-index:9999;background:none;border-bottom:0;">

  <ul style="float:right">
  </ul>
  </div>


    <div style="width:100%;height: 970px;position:absolute;float:left;top:0px;z-index:999;transform:rotate(-90deg);left: calc(10% + 80px);">
  <!--
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#FFF" fill-opacity="1" d="M0,256L15,240C30,224,60,192,90,192C120,192,150,224,180,208C210,192,240,128,270,122.7C300,117,330,171,360,181.3C390,192,420,160,450,138.7C480,117,510,107,540,106.7C570,107,600,117,630,144C660,171,690,213,720,218.7C750,224,780,192,810,192C840,192,870,224,900,208C930,192,960,128,990,90.7C1020,53,1050,43,1080,58.7C1110,75,1140,117,1170,165.3C1200,213,1230,267,1260,272C1290,277,1320,235,1350,213.3C1380,192,1410,192,1425,192L1440,192L1440,320L1425,320C1410,320,1380,320,1350,320C1320,320,1290,320,1260,320C1230,320,1200,320,1170,320C1140,320,1110,320,1080,320C1050,320,1020,320,990,320C960,320,930,320,900,320C870,320,840,320,810,320C780,320,750,320,720,320C690,320,660,320,630,320C600,320,570,320,540,320C510,320,480,320,450,320C420,320,390,320,360,320C330,320,300,320,270,320C240,320,210,320,180,320C150,320,120,320,90,320C60,320,30,320,15,320L0,320Z"></path></svg>
  -->
  <!--
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1740 320"><path fill="#FFF" fill-opacity="1" d="M0,224L34.3,218.7C68.6,213,137,203,206,202.7C274.3,203,343,213,411,197.3C480,181,549,139,617,122.7C685.7,107,754,117,823,144C891.4,171,960,213,1029,202.7C1097.1,192,1166,128,1234,85.3C1302.9,43,1371,21,1406,10.7L1440,0L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
  -->
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#FFF" fill-opacity="1" d="M0,32L40,53.3C80,75,160,117,240,154.7C320,192,400,224,480,202.7C560,181,640,107,720,106.7C800,107,880,181,960,181.3C1040,181,1120,107,1200,64C1280,21,1360,11,1400,5.3L1440,0L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path></svg>

  </div>

  	<div id="register-left">
  	</div>

  	<div id="register-right">
  		<div class="register-form login-form-end">
  			<form class="register" action="" method="POST">
  			<div class="title-form">Logowanie</div>
  			<label>Login:</label> <input type="text" required name="login"><br>
  			<label>Hasło:</label> <input type="password" required name="haslo"><br><div class="error" id="error">Błędny login lub hasło</div><br>
  			<center><input type="submit" name="post_me" value="Logowanie"></center>
  			</form>
  		</div>
  	</div>


  </body>


  <?php
if(isset($_POST['post_me']) || isset($_POST['post_form'])) {
if($error = true) {
  ?>
  <script>
    document.getElementById('error').style.opacity = "1.0";
    document.getElementById('error').innerHTML = "Błędy login lub hasło";
  </script>
  <?php
} else {
    echo 'Error false';
  ?>
  <script>
    document.getElementById('error').style.opacity = "0";
  </script>
  <?php
}
}

   ?>
