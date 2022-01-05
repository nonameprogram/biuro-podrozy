
// Pole z cena :(

function closeRest(x, y, z, l){
  a = document.getElementById("place-filter");
  b = document.getElementById("cena-filter");
  c = document.getElementById("czastrw-filter");
  d = document.getElementById("sort-filter");
  if(x == 1) {
    if(a.style.display == "block") {
      a.style.display = "none";
    }
  }
  if(y == 1) {
    if(b.style.display == "block") {
      b.style.display = "none";
    }
  }
  if(z == 1) {
    if(c.style.display == "block") {
      c.style.display = "none";
    }
  }
  if(l == 1) {
    if(d.style.display == "block") {
      d.style.display = "none";
    }
  }
}

function sort() {
  closeRest(1, 1, 1, 0);
  cf = document.getElementById("sort-filter");
  if(cf.style.display == "block") {
    cf.style.display = "none";
  } else {
    cf.style.display = "block";
  }
}

function myFunction() {
  closeRest(1, 0, 1, 1);
  cf = document.getElementById("cena-filter");
  if(cf.style.display == "block") {
    cf.style.display = "none";
  } else {
    cf.style.display = "block";
  }
}

function czastrw() {
  closeRest(1, 1, 0, 1);
  cf = document.getElementById("czastrw-filter");
  if(cf.style.display == "block") {
    cf.style.display = "none";
  } else {
    cf.style.display = "block";
  }
}

function place() {
  closeRest(0, 1, 1, 1);
  cf = document.getElementById("place-filter");
  if(cf.style.display == "block") {
    cf.style.display = "none";
  } else {
    cf.style.display = "block";
  }
}

function sortselect(a) {
  document.getElementById("sort-filter").style.display = "none";
  a.classList.add("selected");
  document.getElementById("pref-sort").value = a.getAttribute('value');
}

window.addEventListener("click", function(event) {
    var cz = event.target.classList.contains("place-hide");
    var cf = document.getElementById("place-filter");
    if(!cz) {
      if(document.getElementById("place-filter").style.display == "block") {
        cf.style.display = "none";
      }
    }
})

window.addEventListener("click", function(event) {
    var cx = document.getElementById("sort-filter");
    var cz = event.target.classList.contains("sort-hide");
    if(!cz) {
      if(document.getElementById("sort-filter").style.display == "block") {
        cx.style.display = "none";
      }
    }
})

window.addEventListener("click", function(event) {
    var cf = document.getElementById("czastrw-filter");
    var cz = event.target.classList.contains("czastrw-hide");
    console.log(event.target);
    if(!cz) {
      if(cf.style.display == "block") {
        cf.style.display = "none";
        //Edycja pola z cena
        var cno = document.getElementById("dni_od");
        var cnd = document.getElementById("dni_do")
        if(cno.value === "" && cnd.value === "") {document.getElementById("preferowane_dni").value = "Czas trwania";} else{
        if(cno.value === "") {
          var od = "Od";
        } else {
          var od = "Od " + cno.value;
        }
        if(cnd.value === "") {
          var doc = "Do";
        } else {
          var doc = "Do " + cnd.value;
        }
        document.getElementById("preferowane_dni").value = od + " dni - " + doc + " dni";
      }
    }
    }
})

window.addEventListener("click", function(event) {
    var cf = document.getElementById("cena-filter");
    var cz = event.target.classList.contains("cena-hide");
    console.log(event.target);
    if(!cz) {
      if(cf.style.display == "block") {
        cf.style.display = "none";
        //Edycja pola z cena
        var cno = document.getElementById("cena_od");
        var cnd = document.getElementById("cena_do")
        if(cno.value === "" && cnd.value === "") {document.getElementById("preferowana_cena").value = "Cena";} else{
        if(cno.value === "") {
          var od = "Od";
        } else {
          var od = "Od " + cno.value;
        }
        if(cnd.value === "") {
          var doc = "Do";
        } else {
          var doc = "Do " + cnd.value;
        }
        document.getElementById("preferowana_cena").value = od + " zł - " + doc + " zł";
      }
    }
    }
})


    function selfdestroy(e) {
      //Usuwanie tagów
      var tag = e;
      var a = e.getAttribute('data-id');
      document.getElementById('sql-tags').value = document.getElementById('sql-tags').value.replace(a+';','');
      e.remove();
    }


        function inserttag(a) {
          var already = document.getElementById('here-tags').innerHTML;
          var alreadysql = document.getElementById('sql-tags').value;
          if(already.indexOf(a.getAttribute('value')) == -1) {
            document.getElementById('here-tags').innerHTML = already + '<span class="place-tags place-hide" data-id="' + a.getAttribute('value') + '" onclick="selfdestroy(this)">' + a.getAttribute('value') + '<i class="fas fa-times tag-delete place-hide"></i></span>';
            document.getElementById('sql-tags').value = alreadysql + a.getAttribute('value') + ';';
          }
          document.getElementById('lookup').value = "";
          lookupf();
        }

        function sortselect(a) {
          document.getElementById("sort-filter").style.display = "none";
          a.classList.add("selected");
          document.getElementById("pref-sort").value = a.getAttribute('value');
        }

        function lookupf() {
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById("lookup");
          filter = input.value.toUpperCase();
          ul = document.getElementById("myUL");
          li = ul.getElementsByTagName("li");
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
          }
        }
