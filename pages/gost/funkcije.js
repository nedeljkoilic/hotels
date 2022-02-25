var id_tip_sobe = 0;
var br_soba = 0;
var id_hotela_kom;
var id_korisnika_kom;
var id_korisnika_prij;
var id_prijavljenog_kor;
var id_kor_prijava_hotel;
var id_prijavljenog_hotela;
var id_hotela_poruke;
var id_menadzer_poruke;
//Fja za prikazivanje forme za rezervaciju
function showform(cijena_po_danu, ukupna_cijena, id) {
  if (id == 1 || id == 11) {
    id_tip_sobe = 1;
  } else if (id == 2 || id == 21) {
    id_tip_sobe = 2;
  } else if (id == 3 || id == 31) {
    id_tip_sobe = 3;
  } else if (id == 4 || id == 41) {
    id_tip_sobe = 4;
  }

  document.getElementById('levitationRez').removeAttribute('hidden');


  var div_rezervacija = document.getElementById("levitationRez");
  var lblcijena = document.getElementById("cijena_po_danu");
  lblcijena.innerHTML = cijena_po_danu;
  var lblukupna_cijena = document.getElementById("ukupna_cijena");
  br_soba = document.getElementById(id).selectedIndex;
  if (br_soba > 0) {
    lblukupna_cijena.innerHTML = ukupna_cijena * br_soba;

    div_rezervacija.style.visibility = "visible";

  } else alert("Niste odabrali sve parametre za pretragu!");
}
window.addEventListener('click', function (e) {
  if (!document.getElementById('levitationForm').contains(e.target)) {
    if (document.getElementById('levitationRez').contains(e.target)) {
      document.getElementById('levitationRez').style.visibility = 'hidden';
    }

  }
});

function zatvori_rez() {
  document.getElementById('levitationRez').style.visibility = 'hidden';
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

function prikaziPretragu() {
  document.getElementById("pronadjeni_hoteli").style.visibility = "visible";
  var br_osoba = document.getElementById("br_osoba").value;
  var grad_drzava = document.getElementById("grad_drzava").selectedIndex;
  var broj_zvjezdica = document.getElementById("br_zvjezdica").value;
  var dnevna_cijena = document.getElementById("dnevna_cijena").selectedIndex;
  var wifi = document.getElementById("wifi").checked;
  var parking = document.getElementById("parking").checked;
  var dorucak = document.getElementById("dorucak").checked;
  // alert("dorucak:"+dorucak+" parking:"+parking+" wifi:"+wifi);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("pronadjeni_hoteli").innerHTML = this.responseText;
    }
  }
  xhttp.open("GET", "ajax.php?br_osoba=" + br_osoba + "&grad_drzava=" + grad_drzava + "&broj_zvjezdica=" + broj_zvjezdica + "&dnevna_cijena=" + dnevna_cijena + "&wifi=" + wifi + "&parking=" + parking + "&dorucak=" + dorucak, true);

  xhttp.send();


}

function otkaziRez(id_rez) {
  alert(id_rez);
  document.location.href = "./ajax.php?id_rez=" + id_rez;
}

function rezervisi_rez(dolazak, odlazak, id_hotela, id) {

  document.location.href = "./ajax.php?br_soba=" + br_soba + "&dolazak=" + dolazak + "&odlazak=" + odlazak + "&id_hotela=" + id_hotela + "&id_korisnika=" + id + "&id_tip_sobe=" + id_tip_sobe;

  document.getElementById("levitationRez").style.visibility = 'hidden';

}

function logout() {
  document.location.href = "./logout.php";
}

function dodajKomOcjenu(id_korisnika, id_hotela) {
  document.getElementById("komentar_ocjena_levitation").removeAttribute('hidden');
  id_korisnika_kom = id_korisnika;
  id_hotela_kom = id_hotela;

}

function sacuvajKomOcjenu() {

  var komentar = document.getElementById("komentar").value;
  var ocjena = document.getElementById("ocjena").selectedIndex;

  alert(id_hotela_kom);

  document.location.href = "./ajax.php?id_korisnika=" + id_korisnika_kom + "&id_hotela=" + id_hotela_kom + "&komentar=" + komentar + "&ocjena=" + ocjena;
}

window.addEventListener('click', function (e) {
  if (!document.getElementById('komentar_ocjena').contains(e.target)) {
    if (document.getElementById('komentar_ocjena_levitation').contains(e.target)) {
      document.getElementById('komentar_ocjena_levitation').setAttribute('hidden', true);
    }

  }
});


function zatvoriKomOcjenu() {

  document.getElementById('komentar_ocjena_levitation').setAttribute('hidden', true);
}

function prikaziPrijavu(id, id_prijavljenog) {
  document.getElementById('div_prijave').removeAttribute('hidden');
  document.getElementById('div_prijave').style.backgroundColor = "rgba(0, 0, 0, 0.6)";
  id_korisnika_prij = id;
  id_prijavljenog_kor = id_prijavljenog;

}
window.addEventListener('click', function (e) {
  if (!document.getElementById('prijava').contains(e.target)) {
    if (document.getElementById('div_prijave').contains(e.target)) {
      document.getElementById('div_prijave').setAttribute('hidden', true);
    }

  }
});


window.addEventListener('click', function (e) {
  if (!document.getElementById('prijava_hotela').contains(e.target)) {
    if (document.getElementById('div_za_prijave').contains(e.target)) {
      document.getElementById('div_za_prijave').setAttribute('hidden', true);
    }

  }
});

function prijavi() {
  var komentar_prijava = document.getElementById('kom_o_prijavi').value;
  document.location.href = "./ajax.php?id_korisnika_prij=" + id_korisnika_prij + "&id_prijavljenog_kor=" + id_prijavljenog_kor + "&komentar_prijava=" + komentar_prijava;

}

function prikaziPrijavuHotela(id_kor, id_hot) {
  document.getElementById('div_za_prijave').removeAttribute('hidden');
  document.getElementById('div_za_prijave').style.backgroundColor = "rgba(0, 0, 0, 0.6)";
  id_kor_prijava_hotel = id_kor;
  id_prijavljenog_hotela = id_hot;

  //alert(id_kor+" "+id_hot);

}

function prijaviHotel() {

  var komentar_prijava_hotela = document.getElementById('komentar_prijava_hotela').value;
  document.location.href = "./ajax.php?id_kor_pri_hotel=" + id_kor_prijava_hotel + "&id_prijavljenog_hot=" + id_prijavljenog_hotela + "&komentar_prijava_hotela=" + komentar_prijava_hotela;


}

function otkaziPrijavu() {
  document.getElementById('div_za_prijave').setAttribute('hidden', true);
}

function zatvori_prijavu() {
  document.getElementById('div_prijave').setAttribute('hidden', true);
}

/* Ne treba ova fja,podaci su poslati preko forme
function PretraziSobe()
{
     var dolazak=document.getElementById('dolazak').value;
     var odlazak=document.getElementById('odlazak').value;

    
     var tip_sobe=document.getElementById('tip_sobe').value;
     var broj_osoba=document.getElementById('broj_osoba').value;

     alert(dolazak+ " "+odlazak+" "+tip_sobe+" "+broj_osoba );
     alert()

     document.location.href="./sobe.php?dolazak="+dolazak+"&odlazak="+odlazak+"&tip_sobe="+tip_sobe+"&broj_osoba="+broj_osoba;
     

}*/
function postaviMenadzere() {

  var id_hotela = document.getElementById('hotel_poruke').value; //dobijam id izabranog hotela
  id_hotela_poruke = id_hotela;


  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("menadzer_poruke").innerHTML = this.responseText;
    }
  }
  xhttp.open("GET", "ajax.php?id_hotel_poruke=" + id_hotela, true);

  xhttp.send();

}

function prikaziPoruke() {
  document.getElementById('prikaz_poruka').removeAttribute('hidden');
  document.getElementById('poruke_kor_menadzer').style.height = "67%";
  id_menadzer_poruke = document.getElementById('menadzer_poruke').value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("poruke").innerHTML = this.responseText;
    }
  }
  xhttp.open("GET", "ajax.php?id_menadzer_poruke=" + id_menadzer_poruke + "&id_hotela_poruke=" + id_hotela_poruke, true);

  xhttp.send();

}

function omoguciSlanje() {
  document.getElementById('dugme_posalji').disabled = false;
}

function posaljiPoruku() {
  var poruka = document.getElementById('nova_poruka').value;
  alert(poruka);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("poruke").innerHTML = this.responseText;
    }
  }
  xhttp.open("GET", "ajax.php?id_hotela_poruke=" + id_hotela_poruke + "&id_menadzer_poruke=" + id_menadzer_poruke + "&poruka=" + poruka, true);
  document.getElementById('nova_poruka').value = "";
  xhttp.send();
  // document.location.href="./ajax.php?id_hotela_poruke="+id_hotela_poruke+"&id_menadzer_poruke="+id_menadzer_poruke+"&poruka="+poruka;


}