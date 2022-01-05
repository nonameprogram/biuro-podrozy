<?php

session_start();
require_once "connect.php";

?>

<html>
<head>
  <title>Biuro podróży</title>
  <meta charset="UTF-8">
  <link href="../styles/main.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body style="background:rgba(0,0,0,0.01)">

  <div id="nav-logo"></div>

<div class="nav" style="line-height:95px;">
<ul style="float:left">
  <li>Wczasy</li>
  <li>Wycieczki objazdowe</li>
  <li>Nasze kierunki</li>
  <li>Bezpieczne wakacje</li>
  <li class="dropmenu" style="position:relative;display:inline-block">Więcej <i class="fas fa-angle-down" style="margin-left:8px;position:relative;top:2px;"></i>
    <div class="dropdown-content">
    <a href="#">Wyjazdy</a>
    <a href="#">Lotniska</a>
    <a href="#">Promocje</a>
  </div>
  </li>
</ul>

<ul style="float:right">
  <?php
  if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true)) {
    echo '
    <li class="dropdownuser drpm" style="position:relative;display:inline-block">Witaj '.$_SESSION['user'].'<i class="fas fa-angle-down" style="margin-left:8px;position:relative;top:2px;"></i>
      <div class="dropdownuser-content">';
      if($_SESSION['id'] == '1') {
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
    <input type="submit" name="post_form" value="Logowanie">
    </form><br>
    <span class="register">Jeśli nie posiadasz jeszcze konta, <a href="register.php">zarejestruj się</a>.</span>

    </div></li>';
  }
  ?>
</ul>
</div>

<div id="content">
  <div id="oferta">

      <?php

      $id = $_GET['id'];
      $query = 'SELECT * FROM oferty
       INNER JOIN kraje ON kraje.id_kraju = oferty.kraj_oferty INNER JOIN samoloty ON samoloty.id_miejsca = oferty.samolot
       INNER JOIN oceny ON oceny.rating_id = oferty.ocena
       INNER JOIN promocje ON promocje.id_promocji = oferty.nazwa_promocji
       WHERE oferty.id_oferty = '.$id;

       $rezultat = mysqli_query($polaczenie, $query) or die ("Blad zapytania");

       $ile_takich_wynikow = $rezultat->num_rows;
       if($ile_takich_wynikow>0)
       {
         while($row = mysqli_fetch_assoc($rezultat)) {

           $views = mysqli_query($polaczenie, "UPDATE oferty SET views = views+1 WHERE id_oferty = '$id'") or die ("Krzak");

           $zdjecia_url = explode(";", $row['zdjecia']);
           echo '<div id="oferta-left">';
           echo '<div class="oferta-bigphoto" style="background:url(../images/'.$zdjecia_url[0].');background-size:cover;"></div>';

           /* Do zmiany */
           $total = count($zdjecia_url);

           for($i = 0; $i<=$total-1;$i++) {
             echo '<img class="oferta-smallphoto" src="../images/';
             echo $zdjecia_url[$i];
             echo '">';
           }


           /* Wypełnienie brakujących miejsc */
           for($i = $total; $i<=3; $i++) {
             echo '<img class="oferta-smallphoto">';
           }
           echo '</div>';

           /* Informacje o wyciecze */
           echo '<div id="oferta-right">';
           echo '<div class="oferta-row">Nazwa wycieczki</div>';
           echo '<div class="oferta-subrow">'.$row['nazwa_oferty'].'</div>';
           echo '<div class="oferta-row">Kraj</div>';
           echo '<div class="oferta-subrow">'.$row['nazwa_kraju'].'</div>';
           echo '<div class="oferta-row">Miejscowość</div>';
           echo '<div class="oferta-subrow">'.$row['miejscowosc'].'</div>';
           echo '<div class="oferta-row">Pozostałych miejsc</div>';
           echo '<div class="oferta-subrow">'.$row['wolne_miejsca'].'</div>';
           echo '<div class="oferta-row">Tagi</div>';
           echo '<div class="oferta-subrow">';

           $tagi = explode(";", $row['tagi']);
           $count_tags = count($tagi);

           if(!empty($row['tagi'])) {
             for($i = 0; $i <= $count_tags-1; $i++) {
               if(!empty($tagi[$i])) {
                 echo '<span class="tags">'.$tagi[$i].'</span>';
               }
             }
           }

           echo '</div>';
           echo '<div class="oferta-row">Cena</div>';
           echo '<div class="oferta-subrow">'.$row['cena_oferty'].' zł</div>';

           echo '<center><a href="zamow.php?id='.$row['id_oferty'].'"><input type="submit" class="zamow" value="Zamów wycieczkę"></a></center>';
           echo '</div>';

           echo '<div id="oferta-opis-box"><div id="oferta-opis-title" style="margin-right:calc(72% - 157px)">Opis wycieczki</div>';
           echo '<div id="oferta-opis">'.$row['opis'].'</div>';
           echo '<div id="oferta-opis-title" style="width:90px;min-width:90px;margin-top:40px;">Opinie</div>';
           echo '<div id="oferta-opis">Brak danych na temat tej wycieczki.</div>';

           echo '</div>';

           echo '<div id="oferta-ocena-box"><div id="oferta-ocena-title">Oceny wycieczki</div>';
           echo '<div id="oferta-ocena">
           <div style="width:100%;float:left;margin-bottom:20px;">
            <div class="bar-ocena">'.$row['ocena'].'/6</div> '.$row['liczba_glosow'].' opini <span class="see-all">Zobacz wszystkie</span>
           </div>
           <div class="bar-text">Komfort</div><div class="bar"><div class="bar-inside w70"></div></div>
           <div class="bar-text">Wyżywienie</div><div class="bar"><div class="bar-inside"></div></div>
           <div class="bar-text">Pokój</div><div class="bar"><div class="bar-inside w25"></div></div>
           <div class="bar-text">Obsługa hotelowa</div><div class="bar"><div class="bar-inside w35"></div></div>
           </div></div>';

         }
       } else {
         echo 'Nie odnaleziono oferty';
       }


       ?>
  </div>

    <div class="headline2"><div class="line"></div>Popularne Wycieczki</div>
  <!-- ENTRY 1 -->
  <div class="oferta mgr5">
      <div class="oferta-img">
      <div class="bg-zoom" style="background:url('https://r.cdn.redgalaxy.com/http/o2/TUI/hotels/HER41056/S19/11819600.jpg');background-size:cover;"></div>
      </div>
      <div class="oferta-desc" style="width:73%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Włochy</span>
        <span class="oferta-subtitle">Hotel Phoenix</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:27%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;opacity:0;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
      font-family: 'ProximaNova';
      font-size: 15px;
      font-weight: 300;
      margin: -3px 0px;
      text-align: right;
  ">śr cena za os.</span></div>

    </div>
  <!-- ENTRY 2 -->
  <div class="oferta mgr5">
      <div class="oferta-img">
      <div class="bg-zoom" style="background:url('../images/travel.jpg');background-size:cover;"></div>
      </div>
      <div class="oferta-desc" style="width:73%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Włochy</span>
        <span class="oferta-subtitle">Hotel Phoenix</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:27%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;opacity:0;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
      font-family: 'ProximaNova';
      font-size: 15px;
      font-weight: 300;
      margin: -3px 0px;
      text-align: right;
  ">śr cena za os.</span></div>

    </div>
  <!-- ENTRY 3 -->
  <div class="oferta">
      <div class="oferta-img">
      <div class="bg-zoom" style="background:url('../images/bluelagoon.jpg');background-size:cover;"></div>
      </div>
      <div class="oferta-desc" style="width:73%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Włochy</span>
        <span class="oferta-subtitle">Hotel Phoenix</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:27%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;opacity:0;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
      font-family: 'ProximaNova';
      font-size: 15px;
      font-weight: 300;
      margin: -3px 0px;
      text-align: right;
  ">śr cena za os.</span></div>

    </div>

</div>
<script>
    document.querySelectorAll('.oferta-smallphoto').forEach((navImg) => {
        navImg.addEventListener('click', (clickedImg) => {
            if(clickedImg.target.src == "") {
              document.querySelectorAll('.oferta-bigphoto')[0].style.backgroundImage = 'url("../images/empty.png")';
            } else {
              document.querySelectorAll('.oferta-bigphoto')[0].style.backgroundImage = 'url("' + clickedImg.target.src + '")';
            }
        });
    });
</script>
</body>
</html>
