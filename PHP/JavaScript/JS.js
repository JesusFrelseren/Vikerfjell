/*
 Sist endret av Erlend 07.05.2017

 */

// Sindre 28.03.2017

//Til senere bruk
function saveScroll() {
    document.getElementById("scroll_pos").value = document.getElementById("scroll").scrollTop;
}

function innholdReturnId() {
    document.getElementById("option_selected_index").value = document.getElementById('id').selectedIndex;
    document.forms["submit_select"].submit();
}

function toggleOpplastBoks() {
    var opplastBoks = document.getElementById("bildeopplast_container");

    if(opplastBoks.style.display === 'none') {
        opplastBoks.style.display = 'inline-block';
    } else {
        opplastBoks.style.display = 'none';
    }
}

//OnChange funksjon for Select(ListeInnhold).

function changeFunc() {
    var selectBox = document.getElementById("listeinnhold");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    window.location.assign("PHP/innhold.php?id="+selectedValue);

    // var selectedValue = document.getElementById("listeinnhold").options[document.getElementById("listeinnhold").selectedIndex].value;
}
//OnChange funksjon for select i endring av meny
function changeMenyFunc() {
    var selectBox = document.getElementById("listetest");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    window.location.assign("PHP/EndreMeny.php?id="+selectedValue);
}

//OnChange funksjon for select i endring av meny
function visInnholdForMenyLinkmodus(modus) {
    var selectBox = document.getElementById("listetest");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    window.location.assign("PHP/AdministrerBilderLink.php?id="+selectedValue);
}

// Redigere innhold med bold/italic/underline
function formatText(tag) {
    var myTextArea = document.getElementById('innh');
    var myTextAreaValue = myTextArea.value;
    var selected_txt = myTextAreaValue.substring(myTextArea.selectionStart, myTextArea.selectionEnd);
    var before_txt = myTextAreaValue.substring(0, myTextArea.selectionStart);
    var after_txt = myTextAreaValue.substring(myTextArea.selectionEnd, myTextAreaValue.length);
    myTextArea.value = before_txt + '<div class="' + tag + '">'+ selected_txt + '</div>' + after_txt;
}
// Legge til href på selektert tekst i innhold
function formatTextLink() {
    var myTextArea = document.getElementById('innh');
    var tekst = document.getElementById('url_input').value;
    var myTextAreaValue = myTextArea.value;
    var selected_txt = myTextAreaValue.substring(myTextArea.selectionStart, myTextArea.selectionEnd);
    var before_txt = myTextAreaValue.substring(0, myTextArea.selectionStart);
    var after_txt = myTextAreaValue.substring(myTextArea.selectionEnd, myTextAreaValue.length);
    myTextArea.value = before_txt + '<a href=' + tekst + '>' + selected_txt + '</a>' + after_txt;
}


/* Menyscrolling - Menyen er sticky på top */
var header = document.getElementById("myTopnav");
window.onscroll = function(e) {


    if (window.pageYOffset > 138) {
        header.className = "nottop";

    } else {
        header.className = "topnav";
    }
}

function myFunction() {
    var x = document.getElementById("myTopnav");

    if (x.className === "topnav") {
        x.className += " responsive";
    } else if (x.className === "nottop") {
        x.className += " responsive";
    } else if (x.className === "nottop responsive") {
        x.className = "nottop";
    }else {
        x.className = "topnav";
    }
}


function getSelectedOption() {
    var dropdown = document.getElementByID('listetest');
    return dropdown.selected;
}


function getidBilder() {
    var bildebokser = document.getElementsByClassName('bildeinfo_container');
    var idnumre = {};
    for (var i = 0; i < bildebokser.length; i++) {
        if (bildebokser[i].type === "checkbox") {
            var target = bildebokser[i].item;
            if (target.checked) {
                idnumre.push(bildebokser[i].getElementById('id').nodeValue);
            }

        }

    }

    return idnumre;

}

function BilderSettAktivDropdown(aktivIndex) {
    var dropdown = document.getElementById("lenkerdrop");
    dropdown.value = aktivIndex;
}

function populateMenu() {
    var dropdown = document.getElementById("listetest");
    var field = document.getElementById("idtest");

    var str = dropdown.options[dropdown.selectedIndex].innerHTML;
    if(str.includes("Submenytekst")) {
        var trim = str.trim();
        var sub = trim.substring(16);
        field.value = sub;
    } else {
        var trim = str.trim();
        var sub = trim.substring(11);
        field.value = sub;
    }

}

function oppdaterSide(oppdaterAlt) {
    var modal = document.getElementById('modalProgress');
    modal.style.display = "block";

    document.getElementById("myTopnav").style.display = "none";
    oppdaterAlt.submit();


}