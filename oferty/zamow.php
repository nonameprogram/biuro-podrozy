<!-- SYSTEM WYSZUKIWANIA OFERT -->

<?php

session_start();
require_once "connect.php";

?>
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

<?php

if(!isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==false) && empty($_SESSION['id'])) {
  header('Location: ../login.php?continue='.$_GET['id']);
}
?>
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
        if($_SESSION['group_id'] == '1') {
            echo '<a href="http://localhost/biuro_podrozy/admin/copyadmincp.php">Panel administratora</a>';
        } else {
            echo '<a href="#">Panel użytkownika</a>';
        }
        echo '
        <a href="http://localhost/biuro_podrozy/wyloguj.php">Wyloguj się</a>
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

<div id="podsumowanie">
  <div id="road-to-end">
    <div class="circle">
      1
    </div>
    <div class="line-end" id="line-end-1"></div>
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

  $id = $_GET['id'];

  $rezultat = mysqli_query($polaczenie, "SELECT cena_oferty, wolne_miejsca from oferty WHERE id_oferty = '$id'") or die ("Blad zapytania");

  while($row = mysqli_fetch_assoc($rezultat)) {
    $cena = $row['cena_oferty'];
    $miejsca = $row['wolne_miejsca'];
  }

  ?>

  <script>

    var uczestnicy = 1;
    var cena = <?php echo $cena; ?>;
    var osoby =  <?php echo $miejsca; ?>;

/*
    function usunUczestnika(e) {
      var a = e.id;
      var c = document.getElementById('uczestnicy-'+a);
      c.remove();
      uczestnicy = uczestnicy-1;


    }
*/


        function dodajUczestnika(){
          if(uczestnicy < osoby) {
            console.log("uczestnicy" + uczestnicy);
            console.log("osoby " + osoby);
          a = document.getElementById("here-new-uczestnik");
          a.innerHTML = a.innerHTML + '<div id="uczestnicy-'+(uczestnicy+1)+'"><div class="uczestnicy-box"><div class="uczestnik-name"><i class="far fa-user uczestnicy-p-icon "></i> Uczestnik '+(uczestnicy+1)+'</div></div><div class="uczestnicy-box data_ur ">Data urodzenia<br><input type="date" class="uczestnicy-input-data" name="data_ur_1"></div><div class="uczestnicy-box"><div class="uczestnicy-usun"><div id="'+(uczestnicy+1)+'" onclick="usunUczestnika(this)"><i class="fas fa-minus-square uczestnicy-usun-icon"></i>Usuń uczestnika</div></div></div></div>';
          uczestnicy = uczestnicy + 1;
          shit(uczestnicy);
          shitc(uczestnicy);

          document.getElementById('dodajUczestnika').style = "line-height:"+ (uczestnicy * 80) + "px";

          document.getElementById("podsumowanie-cena").innerHTML = cena * uczestnicy;
        } else {
          alert('Nie ma więcej wolnych miejsc');
        }
        }

        function shit(a) {
          console.log(document.getElementById("inputcena").value);
          console.log(document.getElementById("inputosoby").value);
        }

    </script>
<div id="konfiguracja">
  <div id="uczestnicy-title">
    Uczestnicy wycieczki
  </div>
  <div id="uczestnicy">
    <!-- Entry 1 -->
    <div style="float:left;width:75%">
    <div id="uczestnicy-1">
    <div class="uczestnicy-box">
      <div class="uczestnik-name"><i class="far fa-user uczestnicy-p-icon "></i> Uczestnik 1</div>
    </div>
    <div class="uczestnicy-box data_ur ">
      Data urodzenia<br>
      <input type="date" class="uczestnicy-input-data" name="data_ur_1">
    </div>
    <div class="uczestnicy-box">
      <div class="uczestnicy-usun">
        <div id="1" onclick="usunUczestnika(this)">
          <i class="fas fa-minus-square uczestnicy-usun-icon"></i>Usuń uczestnika
        </div>
      </div>
    </div>
  </div>
  <div id="here-new-uczestnik" style="width: 100%;float:left"></div>

  </div>
  <div style="float:left;width:25%">
    <div class="uczestnicy-box" style="width:100%;line-height:80px">
      <div onclick="dodajUczestnika()" id="dodajUczestnika">
        <span class="uczestnicy-dodaj-icon">+</span>Dodaj uczestnika
      </div>
    </div>
  </div>
</div>

<div id="uczestnicy-title" style="margin-top:10px">Do zapłaty</div>
  <div id="uczestnicy">
    <div style="float:left;width:75%">
    <div id="uczestnicy-1">
    <div class="podsumowanie-cena-box" style="width:50%">
      Całkowita wartość wycieczki wynosi:<br>
       <div class="podsumowanie-cena" id="podsumowanie-cena"></div> <div class="podsumowanie-zl">ZŁ</div>
       <script>document.getElementById("podsumowanie-cena").innerHTML = cena;</script>
    </div>
  </div>
</div>
<div style="float:left;width:25%">
  <form method="POST" id="payment-ready" action="zamowienie.php">
    <input type="number" name="id" value="<?php echo $id; ?>" style="display:none" readonly="readonly">
    <input type="number" id="inputcena" name="cena" value="2100"  style="display:none" readonly="readonly">
    <input type="number" id="inputosoby" name="osoby" value="1"  style="display:none" readonly="readonly">
    <input type="submit" name="zamowienie_gotowe" class="payment" value="Przejdź do płatności" style="display:block;border:0;font-size: 16px;
    font-family: Proximanova;">
  </form></div>

  <!--<div class="payment" onclick="payment()">Przejdź do płatności</div></div>-->

  </div>

<div id="anim"><div style="width:100%;float:left;"><center>
    <img src="../images/anim.gif" style="margin-top:115px">
  </center></div></div>

<div id="platnosc">
  <div class="platnosc-text">
    <i class="far fa-check-circle" style="width: 100%;
    margin-bottom: 60px;
    font-weight: 300;
    font-size: 100px;color:#6BBB00;"></i>
    Płatność zrealizowana

  </div>
</div>

<div id="potwierdzenie">
  <div class="potwierdzenie-text">
    Dziękujemy za złożenie zamówienia #24<br>
    <span style="font-size:24px">Dalsze informacje znajdziesz w profilu lub w skrzynce odbiorczej.</span>
</div>
</div>
</div>

<script>
if(uczestnicy <= <?php echo $miejsca; ?>) {
<?php

if(isset($_POST['zamowienie_gotowe'])) {


  $id = $_POST['id'];
  $cena = $_POST['cena'];
  $osoby = $_POST['osoby'];

  if($osoby <= $miejsca) {

  $rezultat = mysqli_query($polaczenie, "UPDATE oferty SET wolne_miejsca = (wolne_miejsca - $osoby) WHERE id_oferty = '$id'") or die ("Blad zapytania");

} else {
  alert('Oferta wykorzystana');
}

}


 ?>

}
</script>

<!--
<script>
function payment() {
  document.getElementById("inputcena").value = document.getElementById("podsumowanie-cena").innerHTML;
  document.getElementById("inputosoby").value = uczestnicy;
  console.log(document.getElementById("inputcena").value);
  console.log(document.getElementById("inputosoby").value);
  document.getElementById("podsumowanie").style= "height:500px;transform: translateY(calc(75% - 237px));";
  document.getElementById("konfiguracja").style.display = "none";
  document.getElementById("line-end-2").style.background = "red";
  document.getElementById("anim").style.display = "block";
  setTimeout(function(){
    document.getElementById("anim").style.display = "none";
    document.getElementById("platnosc").style.display = "block";
    setTimeout(function(){
      potwierdzenie();
    }, 3000);
  }, 5000);
}

function potwierdzenie(){
  document.getElementById("platnosc").style.display = "none";
  document.getElementById("line-end-3").style.background ="red";
  document.getElementById("potwierdzenie").style.display = "block";
}
</script>
-->

<script defer>
function shitc(a) {
  document.getElementById("inputcena").value = cena * uczestnicy;
  document.getElementById("inputosoby").value = uczestnicy;
  console.log(document.getElementById("inputcena").value);
  console.log(document.getElementById("inputosoby").value);
}
</script>


</div>
</body>
</html>
