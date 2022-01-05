<?php

session_start();
require_once "connect.php";

if(isset($_SESSION['group_id'])) {
  if($_SESSION['group_id'] != "1") {
    header('Location: ../index.php');
  } else {
    if(isset($_POST['dodaj'])) {
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


  <Script>
  var a = 1;

  function morePhotos() {
    if(a!=4) {
    document.getElementById("st"+a).style.display = "block";
    document.getElementById("zdjecia-"+a).required = true;
    a++;
  }
  }
  </script>


<?php

  echo '<div id="edit-box">';
  echo '<form action="" method="POST">';
  echo '<div class="edit-title">Podstawowe informacje</div>';
  echo '<div class="edit-row"><label>Nazwa oferty</label><input type="text" name="nazwa_oferty"></div><br>';
  echo '<div class="edit-row"><label>Kraj</label><input type="text" name="kraj"></div><br>';
  echo '<div class="edit-row"><label>Miejscowość</label><input type="text" name="miejscowosc"></div><br>';
  echo '<div class="edit-row"><label>Cena</label><input type="number" name="cena"></div><br>';
  echo '<div class="edit-row"><label>Ilość miejsc</label><input type="number" name="ilosc_miejsc"></div><br>';
  echo '<div class="edit-title">Opis</div>';
  echo '<div class="edit-row"><label>Opis</label><textarea rows="8" name="opis"></textarea></div><br>';
  echo '<div class="edit-title">Termin wycieczki</div>';
  echo '<div class="edit-row"><label>Czas trwania (dni)</label><input type="number" name="czas_trwania"></div><br>';
  echo '<div class="edit-row"><label>Data rozpoczęcia</label><input type="date" name="data_od"></div><br>';
  echo '<div class="edit-row"><label>Data zakończenia</label><input type="date" name="data_do"></div><br>';
  echo '<div class="edit-title">Inne</div>';
  echo '<div class="edit-row"><label>Transport</label><input type="text" name="samolot"></div><br>';
  echo '<div class="edit-title">Zdjęcia</div>';
  echo '<div class="edit-row"><label>Ścieżka do zdjęć<span class="dodaj-zdjecie" onclick="morePhotos()" style="margin-left:10px" required>+</span></label><input type="text" id="zdjecia-1" name="zdjecia-1" style="margin-right:0%"></div><br>';
  echo '<div class="edit-row" id="st1" style="display:none"><label></label><input id="zdjecia-2" type="text" name="zdjecia-2"></div><br>';
  echo '<div class="edit-row" id="st2" style="display:none"><label></label><input id="zdjecia-3" type="text" name="zdjecia-3"></div><br>';
  echo '<div class="edit-row" id="st3" style="display:none"><label></label><input id="zdjecia-4" type="text" name="zdjecia-4"></div><br>';
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
  echo '<div class="edit-row"><label>Nazwa promocji</label><input type="text" value="brak" name="nazwa_promocji"></div><br>';
  echo '<div class="edit-row"><label>Wartość promocji (%)</label><input type="number" value="0" name="wartosc_promocji" required></div><br>';
  echo '<center><input class="zapisz-zmiany" type="submit" name="dodaj" value="Zapisz zmiany" required></center>';
  echo '</form>';
  echo '</div>';

if (isset($_POST['dodaj'])){

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

$zdjecia_end = $_POST['zdjecia-1'].";".$_POST['zdjecia-2'].";".$_POST['zdjecia-3'].";".$_POST['zdjecia-4'];
$string_1 = str_replace(";;;", "", $zdjecia_end);
$string_2 = str_replace(";;", "", $string_1);

$kraj = mysqli_query($polaczenie, "SELECT id_kraju FROM kraje WHERE nazwa_kraju = '".$_POST['kraj']."'") or die ("Krzak");

function lastInsertId() {
    global $polaczenie;
    return mysqli_insert_id($polaczenie);
}

/* Kraj wycieczki */

$ile_takich_nickow = $kraj->num_rows;
if($ile_takich_nickow==1)
{
  while($row = mysqli_fetch_assoc($kraj)) {
    $kraj_id = $row['id_kraju'];
  }
} else {
  /* Tworzenie nowego rekordu jeśli nie ma kraju na liście */
  $zap = "INSERT INTO kraje VALUES(NULL, '".$_POST['kraj']."')";

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

$ids = mysqli_query($polaczenie, "SELECT MAX(id_oferty) FROM oferty") or die ("Krzak");
$row = mysqli_fetch_assoc($ids);
$last_id = ($row['MAX(id_oferty)']+1);

  echo 'Próba modyfikacji';

  echo $_POST['nazwa_oferty']."<br>";
  echo $kraj_id."<br>";
  echo $_POST['cena']."<br>";
  echo $_POST['opis']."<br>";
  echo $_POST['miejscowosc']."<br>";
  echo $_POST['ilosc_miejsc']."<br>";
  echo $_POST['ilosc_miejsc']."<br>";
  echo $_POST['czas_trwania']."<br>";
  echo $_POST['data_od']."<br>";
  echo $_POST['data_do']."<br>";
  echo $samolot_id."<br>";
  echo $string_2."<br>";
  echo $tags."<br>";
  echo $last_id."<br>";
  echo $promocja_id."<br>";
  echo $_POST['wartosc_promocji']."<br>";

  $rezultat = mysqli_query($polaczenie, "INSERT INTO oferty VALUES(NULL,
    '".$_POST['nazwa_oferty']."',
    $kraj_id,
    '".$_POST['cena']."',
    '".$_POST['opis']."',
    '".$_POST['miejscowosc']."',
    '".$_POST['ilosc_miejsc']."',
    '".$_POST['ilosc_miejsc']."',
    '".$_POST['czas_trwania']."',
    '".$_POST['data_od']."',
    '".$_POST['data_do']."',
    $samolot_id,
    $last_id,
    '".$string_2."',
    '".$tags."',
    $promocja_id,
    '".$_POST['wartosc_promocji']."', 0)") or die ("Bladc");

    $ocena = mysqli_query($polaczenie, "INSERT INTO oceny VALUES(NULL, 4, 0)") or die ("Krzak");


}
?>

</body>
</html>
