function generatePDF() {
  var doc = new jsPDF('p', 'pt', 'a2'); //create jsPDF object
  doc.fromHTML(document.getElementById("test"), // page element which you want to print as PDF
    0,
    0, {
      'width': 400 //set width
    },
    function (a) {
      doc.save("HTML2PDF.pdf"); // save file name as HTML2PDF.pdf
    });
}

function rezervacije(select_hoteli) {

  var e = document.getElementById(select_hoteli).value;
  var dateod = document.getElementById('od').value;
  var datedo = document.getElementById('do').value;
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function () {
    document.getElementById("test").innerHTML = this.responseText;
  }
  xmlhttp.open("GET", "menadzer_pretraga.php?dateod=" + dateod + "&datedo=" + datedo + "&hotel=" + e);
  xmlhttp.send();

}

function poruke(id_menadzer) {


  var id_korisnik = document.getElementById('sagovornik').value;
  if (id_korisnik != '0') {

    var nova_poruka = document.getElementById('nova_poruka').disabled = false;
    var dugme_posalji = document.getElementById('dugme_posalji').disabled = false;

  } else {
    var nova_poruka = document.getElementById('nova_poruka').disabled = true;
    var dugme_posalji = document.getElementById('dugme_posalji').disabled = true;
  }
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function () {
    document.getElementById("poruke").innerHTML = this.responseText;
  }
  xmlhttp.open("GET", "poruke.php?id_korisnika=" + id_korisnik + "&id_menadzera=" + id_menadzer, false);
  xmlhttp.send();
  var chatHistory = document.getElementById("poruke");
  chatHistory.scrollTop = chatHistory.scrollHeight;

}

function posalji_poruku(id_poruke, id_menadzer) {

  var id_korisnik = document.getElementById('sagovornik').value;
  var tekst_poruke = document.getElementById(id_poruke).value;
  document.getElementById(id_poruke).value = "";
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function () {

  }
  xmlhttp.open("GET", "poruke.php?id_korisnika=" + id_korisnik + "&id_menadzera=" + id_menadzer + "&tekst_poruke=" + tekst_poruke, false);
  xmlhttp.send();

  poruke(id_menadzer);


}