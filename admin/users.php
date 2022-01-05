<?php

session_start();
require_once "connect.php";

if(isset($_SESSION['group_id'])) {
  if($_SESSION['group_id'] != "1") {
    header('Location: ../index.php');
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
  <script>

var id;

  function myFunction(d) {
    id = d.getAttribute("data-id");
    document.getElementById("myModal").style.display = "block";
    var name_old = ("nazwa-" + id);
    var name_new = document.getElementById(name_old).innerHTML;
    document.getElementById('modal-content').innerHTML = "<center>Czy na pewno chcesz usunąć ofertę <br><span class='tytul-oferty'>" + name_new + "</span><form action='' method='post'><button>Anuluj</button>" + "<input type='text' style='display:none' value='" + id + "' name='confirmdelete'>" + "<input type='submit' name='usun-wycieczke' value='Usuń'></form></center>";
    console.log(document.getElementsByClassName("modal-content"));
  }


  $(function mts() {
    $(".myBtn").on('click', function(e) {
      e.preventDefault();
        var $this = $(this),
          id = $this.data("id");
    });
  });


  </script>
</head>
<body>

  <div id="nav-logo"></div>

  <div class="nav" style="line-height:95px;">
  <ul style="float:left">
    <a href="copyadmincp.php"><li>Lista wycieczek</li></a>
    <a href="zamowienia.php"><li>Zamówienia</li></a>
    <a href="users.php"><li>Użytkownicy</li></a>
    <a href="dodaj.php"><li>Dodaj wycieczkę</li></a>
  </ul>

  <ul style="float:right">
    <?php
    if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true)) {
      echo '
      <li class="dropdownuser drpm" style="position:relative;display:inline-block">Witaj '.$_SESSION['user'].'<i class="fas fa-angle-down" style="margin-left:8px;position:relative;top:2px;"></i>
        <div class="dropdownuser-content">
        <a href="../wyloguj.php">Wyloguj się</a>
        </div>
      </li>';
    }
    ?>
  </ul>
  </div>

<div id="container">
    <div id="content">
        <?php

        echo '<div class="oferty-row"><div class="oferty-element oex">Id</div>';
        echo '<div class="oferty-element oex">Nazwa</div>';
        echo '<div class="oferty-element oex" style="width:5%">Hasło</div>';
        echo '<div class="oferty-element oex">Imię</div>';
        echo '<div class="oferty-element oex">Nazwisko</div>';
        echo '<div class="oferty-element oex">E-mail</div>';
        echo '<div class="oferty-element oex">Numer telefonu</div></div>';

        $rezultat = mysqli_query($polaczenie, "SELECT * FROM uzytkownicy") or die ("Blad zapytania");

        while($row = mysqli_fetch_assoc($rezultat)) {
            echo '<div class="oferty-row"><div class="oferty-element oex">'.$row['id_user'].'</div>';
            echo '<div class="oferty-element oex">'.$row['user'].'</div>';
            echo '<div class="oferty-element oex">'.$row['haslo'].'</div>';
            echo '<div class="oferty-element oex">'.$row['imie'].'</div>';
            echo '<div class="oferty-element oex">'.$row['nazwisko'].'</div>';
            echo '<div class="oferty-element oex">'.$row['email'].'</div>';
            echo '<div class="oferty-element oex">'.$row['numer_telefonu'].'</div></div>';
      }
        ?>
    </div>

    <div id="myModal" class="modal">
      <div class="modal-content" id="modal-content">
      </div>
    </div>
</div>

<?php
if(isset($_POST['usun-wycieczke']) && !empty($_POST['usun-wycieczke'])) {
  if(isset($_POST['confirmdelete']) && !empty($_POST['confirmdelete'])) {
    $rezultat = mysqli_query($polaczenie, "DELETE FROM oferty WHERE id_oferty = '".$_POST['confirmdelete']."'") or die ("Blad zapytania");
    echo("<meta http-equiv='refresh' content='0'>");
  }
}


 ?>
