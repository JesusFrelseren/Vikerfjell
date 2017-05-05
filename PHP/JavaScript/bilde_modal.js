//Fra: https://www.w3schools.com/howto/howto_css_modals.asp
//Skreddersydd av Erlend.

function visModal(id){
    var modal = document.getElementsByClassName('modal');
    var img = document.getElementById("img01");

    modal[id].style.display = "block";
    img.src = this.src;

}

// For å krysse vekk modal-overlayen
function skjulModal(id) {
    var modal = document.getElementsByClassName('modal');
    modal[id].style.display = "none";
}