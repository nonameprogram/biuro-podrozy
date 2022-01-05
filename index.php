<?php

session_start();
require_once "connect.php";
?>

<html>
<head>
  <title>Biuro podróży</title>
  <meta charset="UTF-8">
  <link href="styles/main.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  <script src="./js/main.js" defer></script>
</head>
<body>

  <div id="nav-logo"></div>

<div class="nav" style="line-height:95px;">
<ul style="float:left">
  <li><a href="index.php">Wczasy</a></li>
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
      if($_SESSION['group_id'] == '1') {
          echo '<a href="admin/copyadmincp.php">Panel administratora</a>';
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
    <input type="submit" name="post_form" value="Logowanie">
    </form><br>
    <span class="register">Jeśli nie posiadasz jeszcze konta, <a href="register.php">zarejestruj się</a>.</span>

    </div></li>';
  }
  ?>
</ul>
</div>
<div id="header">
  <div style="
    width: 89.5%;
    float: left;
    height: calc(100% - 440px);
    top: 300px;
    position: absolute;
    z-index: 1;
    font-size: 230px;
    font-family: Gilroy-ExtraBold;
    color: rgba(255,255,255,0.3);
    text-align: center;
">WYCIECZKA</div>
  <div class="header-title">Jesteś gotowy na podróż po Filipinach?</div>
  <div class="header-subtitle">Wybierz się w podróż razem z nami</div>
</div>

<div id="content">
  <div id="filter-panel">
    <form action="szukaj.php" method="POST">
    <input type="text" name="kraj" style="display:none">
    <!--
    <div class="input">
      <div class="input-icon"><i class="fas fa-map-marked-alt map-icon"></i></div>
      <input type="text" placeholder="Miejsce podróży" name="miejscowosc">
    </div>
  -->

    <div id="placeshow-filter" class="input" style="position:relative;">
      <div id="place-show-filter-x" class="place-hide" onclick="place()"></div>
      <div class="input-icon"><i class="fas fa-map-marked-alt map-icon"></i></div>
      <input type="text" placeholder="Miejsce podróży" class="place-show-filter" name="miejscowosc" readonly="readonly">
      <div id="place-filter" class="place-hide">
        <div id="tags-container" class="place-hide">
          <input type="text" id="sql-tags" style="float:left;display:none" name="sql_string_tags" readonly="readonly">
          <div id="here-tags" style="float:left">

          </div>
          <input type="text" placeholder="Wyszukaj ..." id="lookup" class="place-hide" onkeyup="lookupf()"></div>
        <ul id="myUL">


        <?php //Tworzenie listy krajów
        $rezultat = mysqli_query($polaczenie, "SELECT DISTINCT nazwa_kraju from kraje") or die ("Blad zapytania");
        while($row = mysqli_fetch_assoc($rezultat)) {
          echo '<li><a onclick="inserttag(this)" class="place-hide" value="'.$row['nazwa_kraju'].'">'.$row['nazwa_kraju'].'</a></li>';
        }
        $rezultat = mysqli_query($polaczenie, "SELECT DISTINCT miejscowosc from oferty") or die ("Blad zapytania");
        while($row = mysqli_fetch_assoc($rezultat)) {
          echo '<li><a onclick="inserttag(this)" class="place-hide" value="'.$row['miejscowosc'].'">'.$row['miejscowosc'].'</a></li>';
        }
        ?>



</ul>
      </div>
    </div>


    <div id="czastrw-show-filter" class="input" style="position:relative;">
      <div id="czastrw-show-filter-x" class="czastrw-hide" onclick="czastrw()"></div>
      <div class="input-icon czastrw-hide"><i class="far fa-calendar-alt rest-icons"></i></div>
      <input type="text" placeholder="Czas trwania" class="czastrw-show-filter czastrw-hide" id="preferowane_dni" disabled>
      <div id="czastrw-filter" class="czastrw-hide">
        Liczba dni<br>
        <div class="input-cena czastrw-hide"><input type="text" placeholder="Od" class="dni czastrw-hide" name="dni_od" id="dni_od"><div class="input-dni czastrw-hide">dni</div></div><div class="czastrw-hide" style="float:left;margin-left: calc(calc(6% - 4.81px) / 2);margin-right: calc(calc(6% - 4.81px) / 2);">-</div>
        <div class="input-cena czastrw-hide"><input type="text" placeholder="Do" class="dni czastrw-hide" name="dni_do" id="dni_do"><div class="input-dni czastrw-hide">dni</div></div>
      </div>
    </div>


    <div id="cena-show-filter" class="input" style="position:relative;">
      <div id="cena-show-filter-x" class="cena-hide" onclick="myFunction()"></div>
      <div class="input-icon cena-hide"><i class="fas fa-wallet rest-icons"></i></div>
      <input type="text" placeholder="Cena" class="cena-show-filter cena-hide" id="preferowana_cena" disabled>
      <div id="cena-filter" class="cena-hide">
        Przedział cenowy<br>
        <div class="input-cena cena-hide"><input type="text" placeholder="Od" class="cena cena-hide" name="cena_od" id="cena_od"><div class="input-cena-zl cena-hide">zł</div></div><div class="cena-hide" style="float:left;margin-left: calc(calc(6% - 4.81px) / 2);margin-right: calc(calc(6% - 4.81px) / 2);">-</div>
        <div class="input-cena cena-hide"><input type="text" placeholder="Do" class="cena cena-hide" name="cena_do" id="cena_do"><div class="input-cena-zl cena-hide">zł</div></div>
      </div>
    </div>

    <div class="input" style="margin-right:0">
      <div class="input-icon"><i class="fas fa-user-friends rest-icons"></i></div>
      <input type="number" placeholder="Ilość osób" name="liczba_osob">
    </div>

    <div id="filter-spacing"></div>


    <div class="input">
      <div class="input-icon"><i class="far fa-calendar rest-icons"></i></div>
      <input type="date" id="data_od" name="data_od">
    </div>
    <script>
      var currDate = new Date();
      var currDateString;
      //Dodanie brakujących zer
      currDateString = currDate.getFullYear() + "-" + ('0' + (currDate.getMonth()+1)).slice(-2) + '-' + ('0' + currDate.getDate()).slice(-2);
      document.getElementById("data_od").value = currDateString;
      //Ograniczenie wyboru daty
      document.getElementById("data_od").min = currDateString;
    </script>
    <div class="input">
      <div class="input-icon"><i class="far fa-calendar rest-icons"></i></div>
      <input type="date" name="data_do">
    </div>

    <div id="sort-show-filter" class="input" style="position:relative;">
      <div id="sort-show-filter-x" class="sort-hide" onclick="sort()"></div>
      <div class="input-icon sort-hide"><i class="fas fa-sort rest-icons sort-hide"></i></div>
      <input type="text" placeholder="Sortowanie" class="sort-show-filter sort-hide" id="pref-sort" name="sort_data">
      <div id="sort-filter" class="sort-hide">
        <div class="sort-row"><a onclick="sortselect(this);" value="Popularność">Popularność</a></div>
        <div class="sort-row"><a onclick="sortselect(this);" value="Ocena: od najlepszej">Ocena: od najlepszej</a></div>
        <div class="sort-row"><a onclick="sortselect(this);" value="Cena: od najntańszych">Cena: od najntańszych</a></div>
        <div class="sort-row"><a onclick="sortselect(this);" value="Cena: od najdroższych">Cena: od najdroższych</a></div>
        <div class="sort-row"><a onclick="sortselect(this);" value="Nazwa: A-Z">Nazwa: A-Z</a></div>
        <div class="sort-row"><a onclick="sortselect(this);" value="Nazwa: Z-A">Nazwa: Z-A</a></div>
      </div>
    </div>


    <input type="submit" value="Szukaj">

    <label class="checkbox">Last Minute<input type="checkbox" name="lastminute"><span class="checkmark"></span></label>
    <label class="checkbox">All inclusive<input type="checkbox" name="allinclusive"><span class="checkmark"></span></label>
    <label class="checkbox">Promocja<input type="checkbox" name="promocja"><span class="checkmark"></span></label>
    <label class="checkbox">Wypoczynek<input type="checkbox" name="wypoczynek"><span class="checkmark"></span></label>
    <label class="checkbox">Objazd<input type="checkbox" name="objazd"><span class="checkmark"></span></label>
  </form>
  </div>

  <div class="headline"><div class="line"></div>Popularne Wycieczki</div>
  <!-- ENTRY 1 -->
  <div class="oferta mgr5">
      <div class="oferta-img">
      <div class="bg-zoom" style="background:url('images/a7.jpg');background-size:cover;"></div>
      </div>
      <div class="oferta-desc" style="width:72%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Włochy</span>
        <span class="oferta-subtitle">Hotel Phoenix</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;opacity:0;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
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
      <div class="bg-zoom" style="background:url('images/travel.jpg');background-size:cover;"></div>
      </div>
      <div class="oferta-desc" style="width:72%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Włochy</span>
        <span class="oferta-subtitle">Hotel Phoenix</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;opacity:0;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
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
      <div class="bg-zoom" style="background:url('images/bluelagoon.jpg');background-size:cover;"></div>
      </div>
      <div class="oferta-desc" style="width:72%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Włochy</span>
        <span class="oferta-subtitle">Hotel Phoenix</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;opacity:0;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
      font-family: 'ProximaNova';
      font-size: 15px;
      font-weight: 300;
      margin: -3px 0px;
      text-align: right;
  ">śr cena za os.</span></div>

    </div>

  <div class="headline" style="margin-top:60px"><div class="line"></div>Last Minute</div>
  <!-- ENTRY 1 -->
  <div class="oferta mgr5">
      <div class="oferta-img">
      <div class="bg-zoom" style="background:url('images/tajlandia.jpg');background-size:cover;"></div>
      </div>
      <div class="oferta-desc" style="width:72%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Tajlandia</span>
        <span class="oferta-subtitle">W orientalny deseń</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;opacity:0;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
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
      <div class="bg-zoom" style="background:url('images/japan.jpeg');background-size:cover;"></div>
      </div>
      <div class="oferta-desc" style="width:72%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Japonia</span>
        <span class="oferta-subtitle">Hotel Phoenix</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
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
      <div class="bg-zoom" style="background:url('images/bluelagoon.jpg');background-size:cover;"></div>
      <div style="height:30px;width:150px;position: relative;margin-top: -250px;line-height: 20px;text-align: center;font-size: 14px;font-family: 'ProximaNova-Regular';color: #333;background: #fff;box-sizing: border-box;border-radius: 0px 0px 0px 30px;float: right;">
    <i class="far fa-clock" style="margin-left:8px;margin-right:4px;position:relative;top:1px;"></i> Last Minute
</div>
<div style="height:40px;width:40px;position: relative;margin-top: -50px;text-align: center;font-size: 14px;font-family: 'ProximaNova-Regular';color: #333;background: #fff;box-sizing: border-box;border-radius: 50%;float: right;margin-right:15px;">
<i class="fas fa-umbrella-beach" style="position:relative;top:1px;line-height: 38px;font-size:17px;color:#0054a6"></i>
</div>

<div style="height:40px;width:40px;position: relative;margin-top: -50px;text-align: center;font-size: 14px;font-family: 'ProximaNova-Regular';color: #333;background: #fff;box-sizing: border-box;border-radius: 50%;float: right;margin-right:65px;">
<i class="fas fa-glass-martini-alt" style="position:relative;top:1px;line-height: 38px;font-size:17px;color:#0054a6"></i>
</div>
      </div>
      <div class="oferta-desc" style="width:72%;float:left;">
        <span class="oferta-stars"></span>
        <span class="oferta-title">Włochy</span>
        <span class="oferta-subtitle">Hotel Phoenix</span>
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
      </div>
  <div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;">2789 zł</span><span style="background:#0054a6;border-radius: 50px;font-size:13px;padding:2px 6px;color:#fff;margin-left:8px;">-28%</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
      font-family: 'ProximaNova';
      font-size: 15px;
      font-weight: 300;
      margin: -3px 0px;
      text-align: right;
  ">śr cena za os.</span></div>
</div>

<div class="headline" style="margin-top:60px"><div class="line"></div>Oferty wybrane dla ciebie</div>
<!-- ENTRY 1 -->
<div class="oferta mgr5">
    <div class="oferta-img">
    <div class="bg-zoom" style="background:url('images/a6.jpeg');background-size:cover;"></div>
    <div style="height:40px;width:40px;position: relative;margin-top: -50px;text-align: center;font-size: 14px;font-family: 'ProximaNova-Regular';color: #333;background: #fff;box-sizing: border-box;border-radius: 50%;float: right;margin-right:15px;">
    <div class="tooltip"><i class="fas fa-map-marked-alt" style="position:relative;top:1px;line-height: 38px;font-size:17px;color:#0054a6"></i><span class="tooltiptext">Objazd</span></div>
    </div>
    </div>
    <div class="oferta-desc" style="width:72%;float:left;">
      <span class="oferta-stars"></span>
      <span class="oferta-title">Chiny - W krainie złotego smoka</span>
      <span class="oferta-subtitle">Wycieczka objazdowa</span>
      <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
    </div>
<div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;opacity:0;">2789 zł</span><br>8299 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
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
    <div class="bg-zoom" style="background:url('images/japan.jpeg');background-size:cover;"></div>
    <div style="height:40px;width:40px;position: relative;margin-top: -50px;text-align: center;font-size: 14px;font-family: 'ProximaNova-Regular';color: #333;background: #fff;box-sizing: border-box;border-radius: 50%;float: right;margin-right:15px;">
    <i class="fas fa-map-marked-alt" style="position:relative;top:1px;line-height: 38px;font-size:17px;color:#0054a6"></i>
    </div>
    </div>
    <div class="oferta-desc" style="width:72%;float:left;">
      <span class="oferta-stars"></span>
      <span class="oferta-title">Japonia</span>
      <span class="oferta-subtitle">Hotel Phoenix</span>
      <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
    </div>
<div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;">2789 zł</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
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
    <div class="bg-zoom" style="background:url('images/bluelagoon.jpg');background-size:cover;"></div>
    <div style="height:30px;width:150px;position: relative;margin-top: -250px;line-height: 20px;text-align: center;font-size: 14px;font-family: 'ProximaNova-Regular';color: #333;background: #fff;box-sizing: border-box;border-radius: 0px 0px 0px 30px;float: right;">
  <i class="far fa-clock" style="margin-left:8px;margin-right:4px;position:relative;top:1px;"></i> Last Minute
</div>
<div style="height:40px;width:40px;position: relative;margin-top: -50px;text-align: center;font-size: 14px;font-family: 'ProximaNova-Regular';color: #333;background: #fff;box-sizing: border-box;border-radius: 50%;float: right;margin-right:15px;">
<i class="fas fa-umbrella-beach" style="position:relative;top:1px;line-height: 38px;font-size:17px;color:#0054a6"></i>
</div>

<div style="height:40px;width:40px;position: relative;margin-top: -50px;text-align: center;font-size: 14px;font-family: 'ProximaNova-Regular';color: #333;background: #fff;box-sizing: border-box;border-radius: 50%;float: right;margin-right:65px;">
<i class="fas fa-glass-martini-alt" style="position:relative;top:1px;line-height: 38px;font-size:17px;color:#0054a6"></i>
</div>
    </div>
    <div class="oferta-desc" style="width:72%;float:left;">
      <span class="oferta-stars"></span>
      <span class="oferta-title">Włochy</span>
      <span class="oferta-subtitle">Hotel Phoenix</span>
      <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
    </div>
<div class="oferta-desc" style="float:left;width:28%;font-size: 20px;text-align: right;padding-top: 15px;font-weight: 700;font-family: Roboto;"><span style="font-size:13px;color:#777;font-family:ProximaNova;text-decoration: line-through;">2789 zł</span><span style="background:#0054a6;border-radius: 50px;font-size:13px;padding:2px 6px;color:#fff;margin-left:8px;">-28%</span><br>2169 <span style="font-family:'ProximaNova'">zł</span><span class="oferta-subtitle" style="
    font-family: 'ProximaNova';
    font-size: 15px;
    font-weight: 300;
    margin: -3px 0px;
    text-align: right;
">śr cena za os.</span></div>
</div>
<!-- <div class="btn-see-more"><i class="fas fa-angle-double-right"></i> Zobacz więcej ofert</div> -->

<div id="subgallery-title">Zdjęcia naszych klientów</div>
<div class="subgallery-photo-s1 subgallery-mgr" style="background:url('images/a1.jpeg');background-size:100%">
  <div class="subgallery-photo-box">
    <div class="subgallery-photo-title">Chiny</div>
  </div>
</div>
<div class="subgallery-photo-s2 subgallery-mgr" style="background:url('images/a2.jpeg');background-size:100%">
  <div class="subgallery-photo-box">
    <div class="subgallery-photo-title">Francja</div>
  </div>
</div>
<div class="subgallery-photo-s1 subgallery-mgr" style="background:url('images/a3.jpeg');background-size:100%">
  <div class="subgallery-photo-box">
    <div class="subgallery-photo-title">Nepal</div>
  </div>
</div>
<div class="subgallery-photo-s2 subgallery-mgr" style="background:url('images/a4.jpeg');background-size:100%">
  <div class="subgallery-photo-box">
    <div class="subgallery-photo-title">Tajlandia</div>
  </div>
</div>
<div class="subgallery-photo-s1" style="background:url('images/a5.jpeg');background-size:100%">
  <div class="subgallery-photo-box">
    <div class="subgallery-photo-title">Włochy</div>
  </div>
</div>
</div>

</div>




<div id="footer">
  <div id="footer-content">
    <!-- PART 1 -->
    <div class="footer-sub-box">
      <div class="footer-sub-title">O nas</div>
      <ul>
        <li>Kim jesteśmy</li>
        <li>Kontakt</li>
        <li>Praca w IT</li>
        <li>Warunki współpracy</li>
      </ul>
    </div>
    <!-- PART 2 -->
    <div class="footer-sub-box">
      <div class="footer-sub-title">Wczasy</div>
      <ul>
        <li>Linie lotnicze</li>
        <li>Oferta</li>
        <li>Nasze kierunki</li>
        <li>Warunki umowy</li>
      </ul>
    </div>
    <!-- PART 3 -->
    <div class="footer-sub-box">
      <div class="footer-sub-title">O nas</div>
      <ul>
        <li>Kim jesteśmy</li>
        <li>Kontakt</li>
        <li>Praca w IT</li>
        <li>Warunki współpracy</li>
      </ul>
    </div>
    <!-- PART 4 -->
    <div class="footer-sub-box">
      <div class="footer-sub-title">Wczasy</div>
      <ul>
        <li>Linie lotnicze</li>
        <li>Oferta</li>
        <li>Nasze kierunki</li>
        <li>Warunki umowy</li>
      </ul>
    </div>
  </div>
  <div id="footer-r">
    Wszelkie prawa zastrzeżone ©2020 twojastrona.pl
  </div>
</div>











</body>
