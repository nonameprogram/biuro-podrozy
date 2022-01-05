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
  <script src="../js/main.js" defer></script>
  <script>

var id;

  function myFunctionh(d) {
    id = d.getAttribute("data-id");
    document.getElementById("myModal").style.display = "block";
    var name_old = ("nazwa-" + id);
    var name_new = document.getElementById(name_old).innerHTML;
    document.getElementById('modal-content').innerHTML = "<center>Czy na pewno chcesz usunąć ofertę <br><span class='tytul-oferty'>" + name_new + "</span><form action='' method='post'><button>Anuluj</button>" + "<input type='text' style='display:none' value='" + id + "' name='confirmdelete'>" + "<input type='submit' name='usun-wycieczke' value='Usuń'></form></center>";
    console.log("Działam");
  }

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


      <div id="filter-panel">
<!--
        <center>
          <form class="find" action="znajdz.php" method="POST">
            <input type="number" placeholder="ID Wycieczki">
            <input type="submit" class="find" value="Znajdź">
          </form>
        </center>
        <div style="width:100%;height:60px;line-height:60px;font-size:16px;text-align:center;float:left;">LUB</div>
-->
        <form action="" method="POST">
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
            <div id="tags-container" class="place-hide" style="width:100%;float:left;">
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


        <input type="submit" name="showspecial" value="Szukaj">

        <label class="checkbox">Last Minute<input type="checkbox" name="lastminute"><span class="checkmark"></span></label>
        <label class="checkbox">All inclusive<input type="checkbox" name="allinclusive"><span class="checkmark"></span></label>
        <label class="checkbox">Promocja<input type="checkbox" name="promocja"><span class="checkmark"></span></label>
        <label class="checkbox">Wypoczynek<input type="checkbox" name="wypoczynek"><span class="checkmark"></span></label>
        <label class="checkbox">Objazd<input type="checkbox" name="objazd"><span class="checkmark"></span></label>
      </form>
      </div>


      <?php

      if(isset($_POST['showspecial'])) {
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
    }

      ?>


        <?php
          echo '<div class="oferty-row"><div class="oferty-element oes">Lp.</div>';
          echo '<div class="oferty-element">Nazwa oferty</div>';
          echo '<div class="oferty-element">Kraj</div>';
          echo '<div class="oferty-element">Cena oferty</div>';
          echo '<div class="oferty-element">Miejscowość</div>';
          echo '<div class="oferty-element">Czas trwania</div>';
          echo '<div class="oferty-element">Data od</div>';
          echo '<div class="oferty-element">Data do</div>';
          echo '<div class="oferty-element oes" style="width:6%">P. miejsca</div>';
          echo '<div class="oferty-element" style="width:4%">Edytuj</div>';
          echo '<div class="oferty-element" style="width:4%">Usuń</div></div>';

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



          try {

            $dbh = new PDO('mysql:host=localhost;dbname=biuro_podrozy','root','');
              if(isset($_POST['showspecial'])) {
                $substr = substr($powerfulquery, 9);
                $new_query = 'SELECT COUNT(*) '.$substr;
                $total = $dbh->query($new_query)->fetchColumn();
              } else {
                $total = $dbh->query('SELECT COUNT(*) FROM oferty')->fetchColumn();
              }

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

              // Wyświetl wszystkie oferty
              if(isset($_POST['showspecial'])) {
                  $stmt = $dbh->prepare($powerfulquery.' LIMIT :limit OFFSET :offset');
              }else {
                $stmt = $dbh->prepare(' SELECT * FROM oferty INNER JOIN kraje ON oferty.kraj_oferty = kraje.id_kraju ORDER BY id_oferty LIMIT :limit OFFSET :offset');
              }

              $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
              $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
              $stmt->execute();

              // Liczba wyników
              if ($stmt->rowCount() > 0) {
                  $stmt->setFetchMode(PDO::FETCH_ASSOC);
                  $iterator = new IteratorIterator($stmt);

                  foreach ($iterator as $row) {
                    echo '<div class="oferty-row"><div class="oferty-element oes">'.$row['id_oferty'].'</div>';
                    echo '<div class="oferty-element" id="nazwa-'.$row['id_oferty'].'">'.$row['nazwa_oferty'].'</div>';
                    echo '<div class="oferty-element">'.$row['nazwa_kraju'].'</div>';
                    echo '<div class="oferty-element">'.$row['cena_oferty'].'</div>';
                    echo '<div class="oferty-element">'.$row['miejscowosc'].'</div>';
                    echo '<div class="oferty-element">'.$row['czas_trwania'].' dni</div>';
                    echo '<div class="oferty-element">'.$row['data_od'].'</div>';
                    echo '<div class="oferty-element">'.$row['data_do'].'</div>';
                    echo '<div class="oferty-element oes" style="width:6%">'.$row['wolne_miejsca'].'</div>';
                    echo '<div class="oferty-element" style="width:4%"><button class="myEdt"><a href="edit.php?id='.$row['id_oferty'].'"><i class="far fa-edit"></i></a></button></div>';
                    echo '<div class="oferty-element" style="width:4%"><button class="myBtn" id="myBtn" data-id="'.$row['id_oferty'].'" onclick="myFunctionh(this)"><i class="far fa-trash-alt"></i></button></div></div>';

                  }

              } else {
                  echo '<p>Brak wyników do wyświetlenia.</p>';
              }



              //Wyświetlanie informacji o stronach
              echo '<div id="real-paging"><center>';
              if($total>0) {
                echo '<div id="paging"><p>Strona ', $page, ' z ', $pages, ', wyświetlono ', $start, '-', $end, ' z ', $total, ' wyników</p>';
              }
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
    $rezultat = mysqli_query($polaczenie, "DELETE FROM oferty WHERE id_oferty = '".$_POST['confirmdelete']."'") or die ("Blad zapytania");
    $rezultat = mysqli_query($polaczenie, "DELETE FROM oceny WHERE rating_id = '".$_POST['confirmdelete']."'") or die ("Blad zapytania");
    echo("<meta http-equiv='refresh' content='0'>");
  }
}


 ?>
