//Sist endret av Erlend Hall 03.02.2017
//Sett over av Alex 06.02.2017



// Menyscrolling //
var header = document.getElementById("nav_bar");
window.onscroll = function(e) {

    console.log(window.pageYOffset);
    if (window.pageYOffset > 88) {
        header.className = "nottop";
    } else {
        header.className = "";
    }
}



//Responsiv meny//
//Definerer et div-element
var mobile = document.createElement('div');

//Det nye elementet får egenskapene. Se style.css:195
mobile.className = 'nav_mobile';

//Henter elementet nav_bar og gir den det genererte child-elementet
document.querySelector('#nav_bar').appendChild(mobile);


var mobile2 = document.createElement('div');
mobile2.className = 'user_controls_mobile';
document.querySelector('#nav_bar').appendChild(mobile2);





