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
    console.log(id);
    document.getElementById("myModal").style.display = "block";
    var name_old = ("zam-" + id);
    var name_new = document.getElementById(name_old).innerHTML;
    document.getElementById('modal-content').innerHTML = "<center>Czy na pewno chcesz usunąć zamówienie o numerze <br><span class='tytul-oferty'>#" +  name_new + "</span><form action='' method='post'><button>Anuluj</button>" + "<input type='text' style='display:none' value='" + id + "' name='confirmdelete'>" + "<input type='submit' name='usun-wycieczke' value='Usuń'></form></center>";
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
        <center><form class="find" action="zamowienia.php" method="POST">
          <input type="number" name="id" placeholder="ID Zamówienia">
          <input type="submit" name="onlyone" class="find" value="Znajdź">
        </form></center><br>
        <?php
          echo '<div class="oferty-row"><div class="zamowienia-element">Lp.</div>';
          echo '<div class="zamowienia-element">Data złożenia</div>';
          echo '<div class="zamowienia-element">ID oferty</div>';
          echo '<div class="zamowienia-element">ID użytkownika</div>';
          echo '<div class="zamowienia-element">Całkowita cena zamówienia</div>';
          echo '<div class="zamowienia-element" style="width:4%">Usuń</div></div>';

/*
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
*/
        ?>

        <?php


if(!isset($_POST['onlyone'])) {
          try {

            $dbh = new PDO('mysql:host=localhost;dbname=biuro_podrozy','root','');
              $total = $dbh->query('
                  SELECT
                      COUNT(*)
                  FROM
                      zamowienia
              ')->fetchColumn();

              $limit = 10;
              $pages = ceil($total / $limit);

              $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                  'options' => array(
                      'default'   => 1,
                      'min_range' => 1,
                  ),
              )));

              $offset = ($page - 1)  * $limit;

              $start = $offset + 1;
              $end = min(($offset + $limit), $total);

              $stmt = $dbh->prepare(' SELECT * FROM zamowienia ORDER BY id_zam LIMIT :limit OFFSET :offset');

              $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
              $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
              $stmt->execute();

              if ($stmt->rowCount() > 0) {
                  $stmt->setFetchMode(PDO::FETCH_ASSOC);
                  $iterator = new IteratorIterator($stmt);

                  foreach ($iterator as $row) {
                    echo '<div class="oferty-row"><div class="zamowienia-element" id="zam-'.$row['id_zam'].'">'.$row['id_zam'].'</div>';
                    echo '<div class="zamowienia-element">'.$row['data_zlozenia'].'</div>';
                    echo '<div class="zamowienia-element">'.$row['id_oferty'].'</div>';
                    echo '<div class="zamowienia-element">'.$row['id_uzytkownika'].'</div>';
                    echo '<div class="zamowienia-element">'.$row['cena_zamowienia'].'</div>';
                    //echo '<div class="oferty-element" id="nazwa-'.$row['id_oferty'].'">'.$row['nazwa_oferty'].'</div>';
                    echo '<div class="zamowienia-element"><button class="myBtn" id="myBtn" data-id="'.$row['id_zam'].'" onclick="myFunction(this)"><i class="far fa-trash-alt"></i></button></div></div>';

                  }

              } else {
                  echo '<p>Brak wyników do wyświetlenia.</p>';
              }



              //Wyświetlanie informacji o stronach
              echo '<div id="real-paging"><center><div id="paging"><p>Strona ', $page, ' z ', $pages, ', wyświetlono ', $start, '-', $end, ' z ', $total, ' wyników</p>';
              echo '<div class="arrow-number">';
              if($page > 1){
                echo '<a href="?page=' . ($page - 1) . '" title="Next page"><img src="../images/back.png" class="arrow-icon arrow-back"></a>';
              } else {
                echo '<a href="?page=' . ($page - 1) . '" title="Next page"><img src="../images/back.png" class="arrow-icon arrow-back arrow-disabled"></a>';
              }
              echo '</div>';
              if($pages < 7) {
                for($i = 1; $i <= $pages; $i++) {
                  if($page == $i) {
                    echo '<a href="?page='.$i.'" class="active-number">'.$i.'</a>';
                  } else {
                    echo '<a href="?page='.$i.'" class="page-number">'.$i.'</a>';
                  }
                }
              } else {
                if($page <= 4) {
                  for($i = 1; $i <=5; $i++) {
                    if($page == $i) {
                      echo '<a href="?page='.$i.'" class="active-number">'.$i.'</a>';
                    } else {
                      echo '<a href="?page='.$i.'" class="page-number">'.$i.'</a>';
                    }
                  }
                  echo '<div class="page-number" style="box-shadow: none">...</div>';
                  echo '<div class="page-number">'.$pages.'</div>';
                } else {
                  echo '<a href="?page=1" class="page-number">1</a>';
                  echo '<a href="?page=2" class="page-number">2</a>';
                  echo '<div class="page-number" style="box-shadow: none">...</div>';
                  if ($page >= $pages-3){
                    for($i = $pages-4; $i <= $pages; $i++) {
                      if($page == $i) {
                        echo '<a href="?page='.$i.'" class="active-number">'.$i.'</a>';
                      } else {
                        echo '<a href="?page='.$i.'" class="page-number">'.$i.'</a>';
                      }
                    }
                  } else {
                    for ($i = $page-2; $i <= $page-1; $i++ ) {
                      if($i <= $pages && $i > 1) {
                        echo '<a href="?page='.$i.'" class="page-number">'.$i.'</a>';
                      }
                    }
                    if($page > 1  && $page < $pages) {
                      echo '<a href="?page='.$page.'" class="active-number">'.$page.'</a>';
                    }

                    for ($i = $page+1; $i <= $page+2; $i++ ) {
                      if($i <= $pages && $i < $pages) {
                        echo '<a href="?page='.$i.'" class="page-number">'.$i.'</a>';
                      }
                    }

                    echo '<div class="page-number" style="box-shadow: none">...</div>';
                    if($page != $pages-3) {
                      echo '<a href="?page='.$pages.'" class="page-number">'.$pages.'</a>';
                    }
                  }
                }
              }
              echo '<div class="arrow-number" style="margin-right:0">';
              if($page < $pages) {
                echo '<a href="?page=' . ($page + 1) . '" title="Next page"><img src="../images/next.png" class="arrow-icon arrow-next"></a>';
              } else {
                echo '<a href="?page=' . ($page + 1) . '" title="Next page"><img src="../images/next.png" class="arrow-icon arrow-next arrow-disabled"></a>';
              }
              echo "</div>";
              echo "</div><center></div>";
            } catch (Exception $e) {
              echo '<p>', $e->getMessage(), '</p>';
            }
} else {

  $rezultat = mysqli_query($polaczenie, "SELECT * FROM zamowienia WHERE id_zam = '".$_POST['id']."'") or die ("Krzak");

  $ile_takich_wierszy = $rezultat->num_rows;
  if($ile_takich_wierszy==1)
  {
    $row = mysqli_fetch_assoc($rezultat);
    echo '<div class="oferty-row"><div class="oferty-element oes" id="zam-'.$row['id_zam'].'">'.$row['id_zam'].'</div>';
    echo '<div class="oferty-element">'.$row['data_zlozenia'].'</div>';
    echo '<div class="oferty-element">'.$row['id_oferty'].'</div>';
    echo '<div class="oferty-element">'.$row['id_uzytkownika'].'</div>';
    echo '<div class="oferty-element">'.$row['cena_zamowienia'].'</div>';
    //echo '<div class="oferty-element" id="nazwa-'.$row['id_oferty'].'">'.$row['nazwa_oferty'].'</div>';
    echo '<div class="oferty-element" style="width:4%"><button class="myEdt"><a href="edit.php?id='.$row['id_zam'].'"><i class="far fa-edit"></i></a></button></div>';
    echo '<div class="oferty-element" style="width:4%"><button class="myBtn" id="myBtn" data-id="'.$row['id_zam'].'" onclick="myFunction(this)"><i class="far fa-trash-alt"></i></button></div></div>';
  } else {
    echo 'Brak wyników';
  }
}

          /*
          font-weight: 100;
margin-left: 4px;
font-size: 20px;
top: 2px;
position: relative;
*/


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
    $rezultat = mysqli_query($polaczenie, "DELETE FROM zamowienia WHERE id_zam = '".$_POST['confirmdelete']."'") or die ("Blad zapytania");
    echo("<meta http-equiv='refresh' content='0'>");
  }
}


 ?>
