window.onload = function () {
  // Array of Images
  var backgroundImg = ["slike/slika1.jpg",
    "slike/slika2.jpg",
    "slike/slika4.jpg",
  ]
  var i = 0;
  setInterval(changeImage, 5000);

  function changeImage() {
    document.getElementById('pozadina').style.backgroundImage = "url('" + backgroundImg[i] + "')";
    i++;
    if (i == 3) {
      i = 0;
    }

  }
}
window.addEventListener('click', function (e) {
  if (!document.getElementById('levitationForm').contains(e.target)) {
    if (document.getElementById('levitationRez').contains(e.target)) {
      document.getElementById('levitationRez').style.visibility = 'hidden';
    }

  }
});

function prikazLevitation(vrijednost) {
  document.getElementById('levitationRez').style.visibility = "visible";
  var izbor = document.getElementById("tipSobe1");
  izbor.value = vrijednost;

}

function sakriji_select() {
  var vrstaNaloga = document.getElementById("vrstaNaloga");
  var sakrivanje = document.getElementById("sakrivanje");
  if (vrstaNaloga.value == 1) {
    sakrivanje.style.display = "none";
  } else {
    sakrivanje.style.display = "block";
  }
}

function validateForm() {
  var pwd = document.getElementById("pwdSign");
  var pwdconf = document.getElementById("pwdConfirm");
  if (pwd.value != pwdconf.value) {
    alert("unesene lozinke se ne poklapaju" + pwd.value + pwdconf.value);
    return false;
  }
}