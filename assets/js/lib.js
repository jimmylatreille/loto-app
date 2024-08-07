/**
 * Fonction qui classe les nombres comme pairs ou impairs d'une combinaison
 * @param  {[Array]} numero combinaison
 * @return {[Array]} pair impair
 */
function getPairImpairCombinaison(numero) {
    var pairImpair = [];

    for (var i = 0; i < numero.length; i++) {
        (numero[i] % 2 === 0) ? pairImpair.push('pair') : pairImpair.push('impair');
    }
    return pairImpair
}


// Function to categorize numero by their range and include their position
function entier_dizaine_vintaine_trentaine_quarantaine(numero) {
    var data = [];

    for (var i = 0; i < numero.length; i++) {


        if (numero[i] <= 10) {
            data.push('entier');
        } else if (numero[i] <= 20) {
            data.push('dizaine');
        } else if (numero[i] <= 30) {
            data.push('vintaine');
        } else if (numero[i] <= 40) {
            data.push('trentaine');
        } else {
           data.push('quarantaine');
       }
   }

   return data;
}

