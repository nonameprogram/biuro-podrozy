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
<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border-radius: 2px;
  width: 20%;
  font-size:18px;
}

.modal-content button, input[type="submit"] {
  border:0;
  padding:8px 18px;
  background:#bbb;
  color:#fff;
  border-radius:2px;
  margin-right:20px;
  margin-top:20px;
  cursor:pointer;
}

.modal-content input[type="submit"] {
  background-color:#0054a6;
}

.modal-content form {
  margin:0;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

<div style="float: left;
    margin-left: 30px;
    background: #fff;
    width: 170px;
    height: 35px;
    margin-top: 17.5px;
    background-size: cover;"></div>

<div class="nav" style="line-height:95px;">
<ul style="float:left">
  <a href="admincp.php"><li>Lista wycieczek</li></a>
  <a href="users.php"><li>Użytkownicy</li></a>
</ul>

<ul style="float:right">
  <?php
  if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true)) {
    echo '
    <li class="dropdownuser drpm" style="position:relative;display:inline-block">Witaj '.$_SESSION['user'].'<i class="fas fa-angle-down" style="margin-left:8px;position:relative;top:2px;"></i>
      <div class="dropdownuser">
      <a href="wyloguj.php">Wyloguj się</a>
      </div>
    </li>';
  }
  ?>
</ul>
</div>

<div id="container">
    <div id="content">
        <?php
          echo '<div class="oferty-row"><div class="oferty-element oes">Lp.</div>';
          echo '<div class="oferty-element">Nazwa oferty</div>';
          echo '<div class="oferty-element" style="width:5%">Kraj</div>';
          echo '<div class="oferty-element oem" style="width:8%">Cena oferty</div>';
          echo '<div class="oferty-element">Miejscowość</div>';
          echo '<div class="oferty-element oem" style="width:8%">Czas trwania</div>';
          echo '<div class="oferty-element oem" style="width:8%">Data od</div>';
          echo '<div class="oferty-element oem" style="width:8%">Data do</div>';
          echo '<div class="oferty-element oes" style="width:6%">Miejsca</div>';
          echo '<div class="oferty-element" style="width:4%">Edytuj</div>';
          echo '<div class="oferty-element" style="width:4%">Usuń</div></div>';

        $rezultat = mysqli_query($polaczenie, "SELECT * FROM oferty INNER JOIN kraje ON oferty.kraj_oferty = kraje.id_kraju ") or die ("Blad zapytania");

        while($row = mysqli_fetch_assoc($rezultat)) {
            echo '<div class="oferty-row"><div class="oferty-element oes">'.$row['id_oferty'].'</div>';
            echo '<div class="oferty-element" id="nazwa-'.$row['id_oferty'].'">'.$row['nazwa_oferty'].'</div>';
            echo '<div class="oferty-element" style="width:5%">'.$row['nazwa_kraju'].'</div>';
            echo '<div class="oferty-element oem" style="width:8%">'.$row['cena_oferty'].'</div>';
            echo '<div class="oferty-element">'.$row['miejscowosc'].'</div>';
            echo '<div class="oferty-element oem" style="width:8%">'.$row['czas_trwania'].' dni</div>';
            echo '<div class="oferty-element oem" style="width:8%">'.$row['data_od'].'</div>';
            echo '<div class="oferty-element oem" style="width:8%">'.$row['data_do'].'</div>';
            echo '<div class="oferty-element oes" style="width:6%">'.$row['ilosc_miejsc'].'</div>';
            echo '<div class="oferty-element" style="width:4%"><button class="myEdt"><a href="edit.php?id='.$row['id_oferty'].'"><i class="far fa-edit"></i></a></button></div>';
            echo '<div class="oferty-element" style="width:4%"><button class="myBtn" id="myBtn" data-id="'.$row['id_oferty'].'" onclick="myFunction(this)"><i class="far fa-trash-alt"></i></button></div></div>';
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
