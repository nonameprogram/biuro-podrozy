<?php

session_start();
require_once "connect.php";

if(!empty($_POST['id']) && !empty($_POST['cena']) && !empty($_POST['osoby'])) {

  $id = $_POST['id'];
  $cena = $_POST['cena'];
  $osoby = $_POST['osoby'];

  $rezultat = mysqli_query($polaczenie, "SELECT cena_oferty, wolne_miejsca from oferty WHERE id_oferty = '$id'") or die ("Blad zapytania");

  while($row = mysqli_fetch_assoc($rezultat)) {
    $miejsca = $row['wolne_miejsca'];
  }

  if($osoby <= $miejsca) {

  $rezultat = mysqli_query($polaczenie, "UPDATE oferty SET wolne_miejsca = (wolne_miejsca - '$osoby') WHERE id_oferty = '$id'") or die ("Blad zapytania");

  $zap = "INSERT INTO zamowienia VALUES(NULL, NOW(), '".$id."', '".$_SESSION['id']."', '".$cena."')";

  /* Id zamowienia */
  function lastInsertId() {
      global $polaczenie;
      return mysqli_insert_id($polaczenie);
  }

  $insert = mysqli_query($polaczenie, $zap) or die ("Blad zapytania2");

  $insert_id = lastInsertId();

  /* Wyswietlenie dalszej czesci zamowienia */
  $error = 'false';
  echo "<script>var error = 'false';</script>";
} else {
  echo "<script>var error = 'true';</script>";
  $error = 'true';
}
} else {
  echo "<script>var error = 'true';</script>";
  $error = 'true';
}

?>

<!-- SYSTEM WYSZUKIWANIA OFERT -->
<html>
<head>
  <title>Biuro podróży</title>
  <meta charset="UTF-8">
  <link href="../styles/main.css" rel="stylesheet" type="text/css">
  <link href="../styles/oferty.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  <script src="./js/main.js" defer></script>
</head>
<body>

  <script>
  function fading(a){
      var increment = 0.05;
      var opacity = 0;
      var instance = window.setInterval(function() {
                document.getElementById(a).style.opacity = opacity
          opacity = opacity + increment;
          if(opacity > 1){
              window.clearInterval(instance);
          }
      },20)
  }
  </script>


  <div style="float: left;
      margin-left: 30px;
      background: #fff;
      width: 170px;
      height: 35px;
      margin-top: 17.5px;
      background-size: cover;"></div>

  <div class="nav" style="line-height:95px;width:calc(98% - 240px);">
  <ul style="float:left">
    <li>Wczasy</li>
    <li>Wycieczki objazdowe</li>
    <li>Nasze kierunki</li>
    <li>Bezpieczne wakacje</li>
    <li class="dropmenu" style="position:relative;display:inline-block">Więcej <i class="fas fa-angle-down" style="margin-left:8px;position:relative;top:2px;"></i>
      <div class="dropdown-content">
      <a href="#">Link 1</a>
      <a href="#">Link 2</a>
      <a href="#">Link 3</a>
    </div>
    </li>
  </ul>

  <ul style="float:right">
    <?php
    if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true)) {
      echo '
      <li class="dropdownuser drpm" style="position:relative;display:inline-block">Witaj '.$_SESSION['user'].'<i class="fas fa-angle-down" style="margin-left:8px;position:relative;top:2px;"></i>
        <div class="dropdownuser-content">';
        if($_SESSION['id'] == '3') {
            echo '<a href="admin/admincp.php">Panel administratora</a>';
        } else {
            echo '<a href="#">Panel użytkownika</a>';
        }
        echo '
        <a href="wyloguj.php">Wyloguj się</a>
        </div>
      </li>';
    } else {
      echo '<li class="login-hover" style="position:relative;display:inline-block;height:80px;">Logowanie<div class="login-panel">
      <form method="POST" action="login.php" autocomplete="off">
      <input id="username" style="display:none" type="text" name="fakeusernameremembered">
      <input id="password" style="display:none" type="password" name="fakepasswordremembered">
      <input type="text" placeholder="Login" name="login"><br>
      <input type="password" placeholder="Hasło" name="haslo" autocomplete="new-password"><br>
      <input type="submit" value="Logowanie">
      </form><br>
      <span class="register">Jeśli nie posiadasz jeszcze konta, <a href="register.php">zarejestruj się</a>.</span>

      </div></li>';
    }
    ?>
  </ul>
  </div>

<div id="content">
<?php if($error == 'true') {
  echo '<div id="podsumowanie" style="height:500px;transform: translateY(calc(75% - 237px));">';
} else {
  echo '<div id="podsumowanie">';
}
?>
  <div id="road-to-end">
    <div class="circle">
      1
    </div>
    <?php if($error == 'true') {
    echo '<div class="line-end" id="line-end-1" style="background:#eee!important;"></div>';
  } else {
    echo '<div class="line-end" id="line-end-1"></div>';
  }?>
    <div class="circle">
      2
    </div>
    <div class="line-end" id="line-end-2"></div>
    <div class="circle">
      3
    </div>
    <div class="line-end" id="line-end-3"></div>
    <div class="circle">
      4
    </div>
  </div>

  <div id="road-to-end-text">
    <div class="text-pods" style="width:101px;left: -28px;position: relative;">Terminy i Cena</div>
    <div class="text-pods" style="width:85px;position: relative;left: -38px;">Konfiguracja</div>
    <div class="text-pods" style="width:64px;position: relative;left: -26px;">Płatność</div>
    <div class="text-pods" style="width:81px;position: relative;left: -20px;">Potwierdzenie</div>
  </div>

<?php
    if($error != 'true') {
echo '<div id="anim"><div style="width:100%;float:left;"><center>
    <img src="../images/anim.gif" style="margin-top:115px">
  </center></div></div>

<div id="platnosc">
  <div class="platnosc-text">
    <i class="far fa-check-circle" id="payment-circle"></i>
    Płatność zrealizowana

  </div>
</div>

<div id="potwierdzenie">
  <div class="potwierdzenie-text" id="potwierdzenie-text">
    Zamówienie nr #'.$insert_id.' zostalo zrealizowane<br>
    <span style="font-size:24px">Dalsze informacje znajdziesz w profilu lub w skrzynce odbiorczej.</span>
</div>
</div>
</div>
';
} else {
  echo '
  <div id="potwierdzenie" style="display:block">
    <div class="potwierdzenie-text">
      Wystąpił błąd<br>
      <span style="font-size:24px">Oferta została wykorzystana lub nie istnieje</span>
  </div>
  </div>

  ';
}

?>

<script>

window.onload = function() {
  if(error != 'true') {
    payment();
  } else {
    potwierdzenie();
  }
};

function payment() {
  if(error != 'true') {
  document.getElementById("podsumowanie").style= "height:500px;transform: translateY(calc(75% - 237px));";
  document.getElementById("line-end-2").style.background = "red";
  document.getElementById("anim").style.display = "block";
  setTimeout(function(){
    document.getElementById("anim").style.display = "none";
    document.getElementById("platnosc").style.display = "block";
    fading("platnosc");
    setTimeout(function(){
      potwierdzenie();
    }, 3000);
  }, 5000);
}
}

function potwierdzenie(){
    if(error != 'true') {
  document.getElementById("platnosc").style.display = "none";
  document.getElementById("line-end-3").style.background ="red";
  document.getElementById("potwierdzenie").style.display = "block";


}

fading("potwierdzenie");
}
</script>



</div>
</body>
</html>
