//**********************************************************//
// FONCTIONNEMENT DU TIMER                                 //
//*********************************************************//
// je déclare mes variables
var i = 0;
let temps = 120 // exprimé en seconde il correspond à 2 minutes il sera le temps souhaité

// Timer
const timerElement = document.getElementById("timer")
function diminuerTemps() {
  timerElement.innerText = temps // modifier la  valeur de notre timer
  temps = temps <= 0 ? 0 : temps - 1 //permet de maintenir temps à 0
  if (temps > 0) {
    move(); // j'appelle move pour mettre à jour ma progress bar
  }
  else if (temps == 0) {
    window.alert("Mince le temps est terminé... Tu peux retenter ta chance en rechargeant la page.")
  }
}
setInterval(diminuerTemps, 1000)

//Fonctionnement de la progress bar
function move() { //deplacement de la progress bar tout au long de la partie.
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");// selection de notre div mybar dans notre html
    var width = 1;
    var id = setInterval(frame, 1200); // déclaration de l'interval de temps
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
      }
    }
  }
}