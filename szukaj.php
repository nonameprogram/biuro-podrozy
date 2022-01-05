<!-- SYSTEM WYSZUKIWANIA OFERT -->

<?php

session_start();
require_once "connect.php";

?>
<html>
<head>
  <title>Biuro podróży</title>
  <meta charset="UTF-8">
  <link href="styles/main.css" rel="stylesheet" type="text/css">
  <link href="styles/oferty.css" rel="stylesheet" type="text/css">
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
      if($_SESSION['id'] == '1') {
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

<div id="content">

<!--
<div class="oferta">
  <div class="oferta-img">
    <div class="oferta-promocja">Rabat 20%</div>
  </div>
  <div class="oferta-sub">
    <div class="tags-container">
      <span class="tags-stars">5.3/6 <i class="fas fa-star"></i> (168 opini)</span><span class="tags">Japonia</span><span class="tags">Wycieczka objazdowa</span>
    </div>
    <div class="oferta-title">Wycieczka do Japonii </div>
    <div class="oferta-subtitle">Podróz po kraju kwitnącej wiśni</div>
    <div class="oferta-info-row"><i class="far fa-calendar-alt calendar"></i> 02.12.2020 - 09.12.2020 (8 dni)</div>
    <div class="oferta-info-row"><i class="fas fa-plane plane"></i> Katowice</div>
    <div class="oferta-info-row"><span class="material-icons food">restaurant</span> All inclusive</div>
  </div>
  <div class="oferta-sub2">
    <div class="cena">
      4 999 zł / os.
    </div>
    <div class="see-more">
      Zobacz oferte
    </div>
  </div>

</div>
<div class="oferta">
  <div class="oferta-img">
    <div class="oferta-promocja">Rabat 20%</div>
  </div>
  <div class="oferta-sub">
    <div class="tags-container">
      <span class="tags-stars">5.3/6 <i class="fas fa-star"></i> (168 opini)</span><span class="tags">Japonia</span><span class="tags">Wycieczka objazdowa</span>
    </div>
    <div class="oferta-title">Wycieczka do Japonii </div>
    <div class="oferta-subtitle">Podróz po kraju kwitnącej wiśni</div>
    <div class="oferta-info-row"><i class="far fa-calendar-alt calendar"></i> 02.12.2020 - 09.12.2020 (8 dni)</div>
    <div class="oferta-info-row"><i class="fas fa-plane plane"></i> Katowice</div>
    <div class="oferta-info-row"><span class="material-icons food">restaurant</span> All inclusive</div>
  </div>
  <div class="oferta-sub2">
    <div class="stara-cena" style="margin-top:91px;text-align:center;float:right;color:#aaa;font-size:16px;text-decoration:line-through">
      5899 zł / os.
    </div>
    <div class="cena nowa-cena">
      4 999 zł / os.
    </div>
    <div class="see-more">
      Zobacz oferte
    </div>
  </div>

</div>
-->

<?php
/* Zasysanie danych */
$miejscowosc = $_POST['miejscowosc'];
$dni_od = $_POST['dni_od'];
$dni_do = $_POST['dni_do'];
$cena_od = $_POST['cena_od'];
$cena_do = $_POST['cena_do'];
$liczba_osob = $_POST['liczba_osob'];
$data_od = $_POST['data_od'];
$data_do = $_POST['data_do'];
$sort = $_POST['sort_data'];
$sql_string_tags = $_POST['sql_string_tags'];

/* Początek zapytania */
$query = "SELECT * FROM oferty
 INNER JOIN kraje ON kraje.id_kraju = oferty.kraj_oferty INNER JOIN samoloty ON samoloty.id_miejsca = oferty.samolot
 INNER JOIN oceny ON oceny.rating_id = oferty.ocena
 INNER JOIN promocje ON promocje.id_promocji = oferty.nazwa_promocji
 WHERE";

if($sql_string_tags){
  $sql_string_tags_copy = substr($sql_string_tags, 0, strlen($sql_string_tags)-1);
  $sql_tags_explode = explode(";", $sql_string_tags_copy);
  $tags = count($sql_tags_explode);

  $zap_tags = '';
  $zap_miejsca = '';

  for($i=0; $i<$tags; $i++) {
    //Budowa zapytania
    $zap_miejsca = $zap_miejsca." OR (oferty.miejscowosc = '".$sql_tags_explode[$i]."' OR kraje.nazwa_kraju = '".$sql_tags_explode[$i]."')";
  }

  $zap_miejsca_copy = substr($zap_miejsca, 3, strlen($zap_miejsca));
  $zap_miejsca_copy2 = '('.$zap_miejsca_copy.')';
  $full_query_tags = " AND ".$zap_miejsca_copy2;
  $query = $query.$full_query_tags;
}

/* Składanie zapytania */

/* Miejscowość */
if($miejscowosc) {
  $zap_miejsc = " AND oferty.miejscowosc = '$miejscowosc'";
  $query = $query.$zap_miejsc;
}

/* Czas trwania */
if($dni_od) {
  $zap_dni = " AND oferty.czas_trwania >= '$dni_od'";
  $query = $query.$zap_dni;
}

if($dni_do) {
  $zap_dni = " AND oferty.czas_trwania <= '$dni_do'";
  $query = $query.$zap_dni;
}

/* Pozostałe wolne miejsca */
if($liczba_osob) {
  $zap_osoby = " AND oferty.wolne_miejsca >= '$liczba_osob'";
  $query = $query.$zap_osoby;
}

/* Cena od */
if($cena_od) {
  $zap_cena_od = " AND oferty.cena_oferty >= '$cena_od'";
  $query = $query.$zap_cena_od;
}

/* Cena do */
if($cena_do) {
  $zap_cena_do = " AND oferty.cena_oferty <= '$cena_do'";
  $query = $query.$zap_cena_do;
}

/* Data od */
if($data_od) {
  $zap_data_od = " AND oferty.data_od >= '$data_od'";
  $query = $query.$zap_data_od;
}

/* Data do */
if($data_do) {
  $zap_data_do = " AND oferty.data_do <= '$data_do'";
  $query = $query.$zap_data_do;
}

/* Odnajdź tagi */

if(isset($_POST['lastminute'])) {
  echo 'lastminute';
  $query = $query." AND oferty.tagi LIKE '%Last Minute%'";
}

if(isset($_POST['allinclusive'])) {
  $query = $query." AND oferty.tagi LIKE '%All inclusive%'";
}

if(isset($_POST['promocja'])) {
  $query = $query." AND oferty.tagi LIKE '%Promocja%'";
}

if(isset($_POST['wypoczynek'])) {
  $query = $query." AND oferty.tagi LIKE '%Wypoczynek%'";
}

if(isset($_POST['objazd'])) {
  $query = $query." AND oferty.tagi LIKE '%Objazd%'";
}



/* Usuwanie pierwszego AND */
$check = strpos($query, "WHERE");
$query2 = substr($query, 0, $check+6);
$query3 = substr($query, $check+9, strlen($query));

//$powerfulquery = $query2.$query3." AND".$zap_tags_copy." AND".$zap_miejsca_copy;
$powerfulquery = $query2.$query3;

/* Sortowanie według wybranych opcji */
if($sort) {
  if($sort == 'Popularność') {
    $zap_sort = " ORDER BY oferty.views DESC";
  } elseif ($sort == "Ocena: od najlepszej") {
    $zap_sort = " ORDER BY oceny.ocena DESC";
  } elseif ($sort == "Cena: od najntańszych") {
    $zap_sort = " ORDER BY oferty.cena_oferty ASC";
  } elseif ($sort == "Cena: od najdroższych") {
    $zap_sort = " ORDER BY oferty.cena_oferty DESC";
  } elseif ($sort == "Nazwa: A-Z") {
    $zap_sort = " ORDER by oferty.nazwa_oferty ASC";
  } elseif ($sort == "Nazwa: Z-A") {
    $zap_sort = " ORDER BY oferty.nazwa_oferty DESC";
  }
  $powerfulquery = $powerfulquery.$zap_sort;
}



$rezultat = mysqli_query($polaczenie, $powerfulquery) or die ("Blad zapytania");

$ile_takich_wynikow = $rezultat->num_rows;
if($ile_takich_wynikow>0)
{
  echo '<div id="sort-results">Znaleziono '.$ile_takich_wynikow;
  if($ile_takich_wynikow == 1) {
    echo ' ofertę spełniającą';
  } elseif ($ile_takich_wynikow > 1 && $ile_takich_wynikow <= 5) {
    echo ' oferty spełniające';
  } else {
    echo ' ofert spełniających';
  }
  echo ' twoje kryteria</div>';
} else {
  echo "<br>Nie znaleziono żadnych ofert pasujących do twoich kryteriów.";
}

/* Wyświetlenie wyszukanych ofert */
while($row = mysqli_fetch_assoc($rezultat)) {

  $tagi = explode(";", $row['tagi']);
  $count_tags = count($tagi);

  $zdjecia_url = explode(";", $row['zdjecia']);
  echo '
  <div class="oferta"><div class="oferta-img" style="background:url(../biuro_podrozy/images/'.$zdjecia_url[0].');background-size:cover;">';
    if($row['nazwa_promocji'] != 1) {
          $spacje = str_replace(" ", "-", $row['nazwa_promocj']);
          echo '<div class="oferta-promocja promocja-'.$spacje.'">'.$row['nazwa_promocj'];
          if($row['wartosc_promocji'] > 0 ) {
            echo ' '.$row['wartosc_promocji'].'<i class="fas fa-percent percent"></i>';
          }
          echo '</div>
        ';}
  echo '</div><div class="oferta-sub"><div class="tags-container"><span class="tags-stars">'.$row['ocena'].'/6 <i class="fas fa-star"></i> ('.$row['liczba_glosow'].' opini)</span><span class="tags">'.$row['nazwa_kraju'].'</span>';
  if(!empty($row['tagi'])) {
    for($i = 0; $i <= $count_tags-1; $i++) {
      if(!empty($tagi[$i])) {
        echo '<span class="tags">'.$tagi[$i].'</span>';
      }
    }
  }
  echo '</div>
      <div class="oferta-title">'.$row['nazwa_oferty'].'</div>
      <div class="oferta-subtitle">Przykładowy krótki opis wycieczki</div>
      <div class="oferta-info-row"><i class="far fa-calendar-alt calendar"></i>'.$row['data_od'].' - '.$row['data_do'].' ('.$row['czas_trwania'].' dni)</div>
      ';
  if(isset($row['samolot']) && !empty($row['samolot'])) {
    echo '<div class="oferta-info-row">';
    if($row['samolot'] == 1) {
      echo '<i class="fas fa-car-alt car"></i>';
    } else {
    echo '<i class="fas fa-plane plane"></i>';
  }
  echo $row['nazwa_miejsca'].'</div>';
}
  echo '    <div class="oferta-info-row"><span class="material-icons food">restaurant</span> All inclusive</div>
    </div>
    <div class="oferta-sub2">
      <!-- NORMALNA CENA -->
      <div class="cena">
        '.$row['cena_oferty'].' zł / os.
      </div>
      <a href="../biuro_podrozy/oferty/show.php?id='.$row['id_oferty'].'">
      <div class="see-more">
        Zobacz ofertę
      </div>
      </a>
    </div>

  </div>
  ';
}

mysqli_free_result($rezultat);

 ?>

</div>
</body>
</html>
