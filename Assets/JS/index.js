//**********************************************************//
// FONCTIONNEMENT PRINCIPAL DU JEU                          //
//*********************************************************//
var motifsCartes = [1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 11, 11, 12, 12, 13, 13, 14, 14]; // je déclare mes motifs de cartes 

var etatsCartes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];  // j'initialise mes cartes face retournée.

var cartesRetournees = []; // on crée le tableau qui contiendra les cartes retournées.

var nbPairesTrouvees = 0; //on initialise le compteur des paires trouvées à 0, ce compteur nous permettra de définir a quel moment la partie est terminée en fonction du nombre de paires trouvées.

var imgCartes = document.getElementById("container_game").getElementsByTagName("img");

for (var i = 0; i < imgCartes.length; i++) {
    imgCartes[i].noCarte = i; //Ajout de la propriété noCarte à l'objet img
    imgCartes[i].onclick = function () {
        gameControl(this.noCarte);
    }
}
distribution();

function display(noCarte) {
    switch (etatsCartes[noCarte]) {
        case 0:
            imgCartes[noCarte].src = "Assets/img/cartes/fondcarte.jpg"; // Etat 0 la carte est retournée 
            break;
        case 1:
            imgCartes[noCarte].src = "Assets/img/cartes/" + motifsCartes[noCarte] + ".png"; // etat 1 la carte s'affiche
            break;
        case -1:
            imgCartes[noCarte].style.visibility = "hidden"; // etat -1 les paires ont été trouvées, elle se masquent donc pour simplifier la partie
            break;
    }
}
function distribution() { // distribution des cartes et répartition au hasard.
    for (var position = motifsCartes.length - 1; position >= 1; position--) {
        var hasard = Math.floor(Math.random() * (position + 1));// on définit grâce au random une position alétatoire.
        var sauve = motifsCartes[position];
        motifsCartes[position] = motifsCartes[hasard];
        motifsCartes[hasard] = sauve;
    }
}
function gameControl(noCarte) { // limite à 2 le retournement des cartes et modifie l'état des cartes en fonction de celles choisient.
    if (cartesRetournees.length < 2) { // si deux cartes choisient alors on affiche.
        if (etatsCartes[noCarte] == 0) {
            etatsCartes[noCarte] = 1;
            cartesRetournees.push(noCarte);
            display(noCarte);
        }
        if (cartesRetournees.length == 2) { // si deux cartes sont en etat 1 (visibles) et qu'elles ne matchent pas alors passe à 0 -> Affiche l'image correspondante.
            var nouveauEtat = 0;
            if (motifsCartes[cartesRetournees[0]] == motifsCartes[cartesRetournees[1]]) { // Si les deux images matchent alors masquent les -> tu les as trouvé :) et ajoute 1 dans les paires trouvées
                nouveauEtat = -1;
                nbPairesTrouvees++;
            }
            etatsCartes[cartesRetournees[0]] = nouveauEtat;
            etatsCartes[cartesRetournees[1]] = nouveauEtat;
            setTimeout(function () {
                display(cartesRetournees[0]);
                display(cartesRetournees[1]);
                cartesRetournees = [];
                if (nbPairesTrouvees == 14) { /// si tu as trouvé 14 paires tu as terminé la partie !
                    window.alert("Bravo tu as gagné dans le temps imparti !!! :D, Tu peux recharger la page pour rejouer :)");
                    //TEMPS A AFFICHER
                    var value_timer = document.getElementById("timer").textContent; // selection la valeur du champs timer 
                    document.getElementById("container_score").style.display = "none"; //  masque le timer car la partie est terminée
                    //Envoie du timer player en AJAX vers le script php best_time.php pour pouvoir le comparer avec le meilleur temps enregistré.
                    $(document).ready(function () {
                        $.ajax({
                            type: 'GET',
                            url: 'index.php', // j'envoie ma donnée vers index.php en méthode GET
                            data: 'time=' + value_timer
                        });
                    });
                }
            }, 750);
        }
    }
}
