<?php

session_start();
require_once "connect.php";

if(isset($_SESSION['group_id'])) {
  if($_SESSION['group_id'] != "1") {
    header('Location: ../index.php');
  } else {
    if(isset($_POST['edit'])) {
      header('Location: copyadmincp.php');
    }
  }
} else {
  header('Location: ../login.php');
}

?>



<html>
<head>
  <title>Biuro Podrozy</title>
  <meta charset="UTF-8">
  <link href="styles/admin.css" rel="stylesheet" type="text/css">
  <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>





<?php
$p = $_GET['id'];

if (isset($p) && !empty($p) && $p > 0 ) {

$rezultat = mysqli_query($polaczenie, "SELECT * FROM oferty INNER JOIN kraje ON oferty.kraj_oferty = kraje.id_kraju
  INNER JOIN promocje ON oferty.nazwa_promocji = promocje.id_promocji
  INNER JOIN samoloty ON oferty.samolot = samoloty.id_miejsca
  WHERE oferty.id_oferty = $p") or die ("Blad zapytania");

while($row = mysqli_fetch_assoc($rezultat)) {

  $zdjecia = explode(";", $row['zdjecia'], 4);
  $total = count($zdjecia);

  for($i = 0; $i <= 3; $i++) {
    if(!isset($zdjecia[$i])) {
      $zdjecia[$i] = "";
    }
  }

  for($i = 0; $i <= 3; $i++){
    if($zdjecia[$i] != "") {
      ${'st'.$i} = "block";
      echo '<script>document.getElementById("zdjecia-'.$i.'").required = true;</script>';
    } else {
      ${'st'.$i} = "none";
    }
  }

  echo '<div id="edit-box">';
  echo '<form action="" method="POST">';
  echo '<div class="edit-title">Podstawowe informacje</div>';
  echo '<div class="edit-row"><label>Nazwa oferty</label><input type="text" name="nazwa_oferty" value="'.$row['nazwa_oferty'].'"></div><br>';
  echo '<div class="edit-row"><label>Kraj</label><input type="text" value="'.$row['nazwa_kraju'].'" name="kraj"></div><br>';
  echo '<div class="edit-row"><label>Miejscowość</label><input type="text" value="'.$row['miejscowosc'].'" name="miejscowosc"></div><br>';
  echo '<div class="edit-row"><label>Cena</label><input type="number" value="'.$row['cena_oferty'].'" name="cena"></div><br>';
  echo '<div class="edit-row"><label>Ilość miejsc</label><input type="number" value="'.$row['wolne_miejsca'].'" name="ilosc_miejsc"></div><br>';
  echo '<div class="edit-title">Opis</div>';
  echo '<div class="edit-row"><label>Opis</label><textarea rows="8" name="opis">'.$row['opis'].'</textarea></div><br>';
  echo '<div class="edit-title">Termin wycieczki</div>';
  echo '<div class="edit-row"><label>Czas trwania (dni)</label><input type="number" value="'.$row['czas_trwania'].'" name="czas_trwania"></div><br>';
  echo '<div class="edit-row"><label>Data rozpoczęcia</label><input type="date" value="'.$row['data_od'].'" name="data_od"></div><br>';
  echo '<div class="edit-row"><label>Data zakończenia</label><input type="date" value="'.$row['data_do'].'" name="data_do"></div><br>';
  echo '<div class="edit-title">Inne</div>';
  echo '<div class="edit-row"><label>Transport</label><input type="text" value="'.$row['nazwa_miejsca'].'" name="samolot"></div><br>';
  echo '<div class="edit-title">Zdjęcia</div>';
  echo '<div class="edit-row"><label>Ścieżka do zdjęć</label><input type="text" value="'.$zdjecia[0].'"  id="zdjecia-1" name="zdjecia-1" style="margin-right:0%"><label style="width: 100px;position: absolute;left: 0;margin-top: 40px"><span class="dodaj-zdjecie" onclick="morePhotos()" required>+</span></label></div><br>';
  echo '<div class="edit-row" id="st1" style="display:'.$st1.'"><label></label><input id="zdjecia-2" type="text" value="'.$zdjecia[1].'" name="zdjecia-2"></div><br>';
  echo '<div class="edit-row" id="st2" style="display:'.$st2.'"><label></label><input id="zdjecia-3" type="text"  value="'.$zdjecia[2].'" name="zdjecia-3"></div><br>';
  echo '<div class="edit-row" id="st3" style="display:'.$st2.'"><label></label><input id="zdjecia-4" type="text"  value="'.$zdjecia[3].'" name="zdjecia-4"></div><br>';
  echo '<div class="edit-title">Tagi</div>';
  echo '<div class="edit-row"><label>Podstawowe</label>';

  echo '<label class="checkbox" style="margin-top:0px">Last Minute<input type="checkbox" name="lastminute" value="Last Minute;"><span class="checkmark"></span></label>
        <label class="checkbox" style="margin-top:0px">All inclusive<input type="checkbox" name="allinclusive" value="All inclusive;"><span class="checkmark"></span></label>
        <label class="checkbox" style="margin-top:0px">Promocja<input type="checkbox" name="promocja" value="Promocja;"><span class="checkmark"></span></label>
        <label class="checkbox" style="margin-top:0px">Wypoczynek<input type="checkbox" name="wypoczynek" value="Wypoczynek;"><span class="checkmark"></span></label>
        <label class="checkbox" style="margin-top:0px">Objazd<input type="checkbox" name="objazd" value="Objazd;"><span class="checkmark"></span></label>';
  echo '<div class="edit-row" style="margin-top:20px"><label>Własne tagi</label><input type="text" name="customtags"></div><br>';

  echo '</div><br>';
  echo '<div class="edit-title">Promocje</div>';
  echo '<div class="edit-row"><label>Nazwa promocji</label><input type="text" value="'.$row['nazwa_promocj'].'" name="nazwa_promocji"></div><br>';
  echo '<div class="edit-row"><label>Wartość promocji (%)</label><input type="number" value="'.$row['wartosc_promocji'].'" name="wartosc_promocji"></div><br>';
  echo '<center><input class="zapisz-zmiany" type="submit" name="edit" value="Zapisz zmiany"></center>';
  echo '</form>';
  echo '</div>';
}
}

if (isset($_POST['edit'])){

  $tags = "";
  if(isset($_POST['lastminute'])) {
    $tags = $tags.$_POST['lastminute'];
  }

  if(isset($_POST['allinclusive'])) {
    $tags = $tags.$_POST['allinclusive'];
  }

  if(isset($_POST['promocja'])) {
    $tags = $tags.$_POST['promocja'];
  }

  if(isset($_POST['wypoczynek'])) {
    $tags = $tags.$_POST['wypoczynek'];
  }

  if(isset($_POST['objazd'])) {
    $tags = $tags.$_POST['objazd'];
  }

  if(!empty('customtags')) {
    $tags = $tags.$_POST['customtags'];
  }

echo $_POST['nazwa_oferty']."<br>";
echo $_POST['cena']."<br>";
echo $_POST['miejscowosc']."<br>";
echo $_POST['czas_trwania']."<br>";
echo $_POST['data_od']."<br>";
echo $_POST['data_do']."<br>";
echo $_POST['ilosc_miejsc']."<br>";
echo $p;

$zdjecia_end = $_POST['zdjecia-1'].";".$_POST['zdjecia-2'].";".$_POST['zdjecia-3'].";".$_POST['zdjecia-4'];
$string_1 = str_replace(";;;", "", $zdjecia_end);
$string_2 = str_replace(";;", "", $string_1);

$kraj = mysqli_query($polaczenie, "SELECT id_kraju FROM kraje WHERE nazwa_kraju = '".$_POST['kraj']."'") or die ("Krzak");

$ile_takich_nickow = $kraj->num_rows;
if($ile_takich_nickow==1)
{
  while($row = mysqli_fetch_assoc($kraj)) {
    $kraj_id = $row['id_kraju'];
  }
} else {
  /* Tworzenie nowego rekordu jeśli nie ma kraju na liście */
  $zap = "INSERT INTO kraje VALUES(NULL, '".$_POST['kraj']."')";

  function lastInsertId() {
      global $polaczenie;
      return mysqli_insert_id($polaczenie);
  }

  $insert = mysqli_query($polaczenie, $zap) or die ("Blad zapytania2");

  $insert_id = lastInsertId();
  $kraj_id = $insert_id;
}


$samolot = mysqli_query($polaczenie, "SELECT id_miejsca FROM samoloty WHERE nazwa_miejsca = '".$_POST['samolot']."'") or die ("Krzak");

/* Rodzaj transportu */

$ile_takich_samolotow = $samolot->num_rows;
if($ile_takich_samolotow==1)
{
  while($row = mysqli_fetch_assoc($samolot)) {
    $samolot_id = $row['id_miejsca'];
  }
} else {
  /* Tworzenie nowego rekordu jeśli nie ma kraju na liście */
  $zap = "INSERT INTO samoloty VALUES(NULL, '".$_POST['samolot']."')";

  $insert = mysqli_query($polaczenie, $zap) or die ("Blad zapytania2");

  $insert_id = lastInsertId();
  $samolot_id = $insert_id;
}

/* Promocja */

$promocja = mysqli_query($polaczenie, "SELECT id_promocji FROM promocje WHERE nazwa_promocj = '".$_POST['nazwa_promocji']."'") or die ("Krzak");

$ile_takich_promocji = $promocja->num_rows;
if($ile_takich_promocji==1)
{
  while($row = mysqli_fetch_assoc($promocja)) {
    $promocja_id = $row['id_promocji'];
  }
} else {
  /* Tworzenie nowego rekordu jeśli nie ma kraju na liście */
  $zap = "INSERT INTO promocje VALUES(NULL, '".$_POST['nazwa_promocji']."', NULL)";

  $insert = mysqli_query($polaczenie, $zap) or die ("Blad zapytania2");

  $insert_id = lastInsertId();
  $promocja_id = $insert_id;
}

  echo 'Próba modyfikacji';

  $rezultat = mysqli_query($polaczenie, "UPDATE oferty SET nazwa_oferty = '".$_POST['nazwa_oferty']."',
  kraj_oferty = '$kraj_id',
  cena_oferty = '".$_POST['cena']."',
  miejscowosc = '".$_POST['miejscowosc']."',
  czas_trwania = '".$_POST['czas_trwania']."',
  zdjecia = '$string_2',
  opis = '".$_POST['opis']."',
  data_od = '".$_POST['data_od']."',
  data_do = '".$_POST['data_do']."',
  wolne_miejsca = '".$_POST['ilosc_miejsc']."',
  samolot = '$samolot_id',
  nazwa_promocji = '$promocja_id',
  tagi = '".$tags."',
  wartosc_promocji = '".$_POST['wartosc_promocji']."'
  WHERE oferty.id_oferty = $p") or die ("Blad");

  if($rezultat) {
    header('Location: copyadmincp.php');
  }

}
?>

<Script>
var a = <?php echo $total; ?>;

function morePhotos() {
  if(a!=4) {
  document.getElementById("st"+a).style.display = "block";
  document.getElementById("zdjecia-"+a).required = true;
  a++;
}
}
</script>

</body>
</html>
