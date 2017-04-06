/*
  Sist endret av Alex 01.04.2017
  Sett over av Erik 01.04.2017
*/

// Sindre 28.03.2017

//OnChange funksjon for Select(ListeInnhold).
function changeFunc() {
    var selectBox = document.getElementById("listeinnhold");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    window.location.assign("http://localhost/html/VikerfjellV3/PHP/innhold.php?id="+selectedValue);
}
//OnChange funksjon for select i endring av meny
function changeMenyFunc() {
    var selectBox = document.getElementById("listetest");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    window.location.assign("http://localhost/html/VikerfjellV3/PHP/EndreMeny.php?id="+selectedValue);
}

//OnChange funksjon for select i endring av meny
function changeMenyFuncBilder() {
    var selectBox = document.getElementById("listetest");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    window.location.assign("http://localhost/vikerfjell/PHP/bildeAdmin.php?id="+selectedValue);
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
/*
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


*/
  /*
var mytimer = 5000;
var x = document.getElementsByClassName("mySlides");
var myIndex = 0;
function carousel() { // av Alex hentet fra W3schools.     gjort endring i "setTimeout"
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}
    x[myIndex-1].style.display = "block";
    setTimeout(carousel, mytimer);

}



function MinusSlides(){

 for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
if(myIndex == 0){
  myIndex = x.length-1;
  myIndex++;
}

myIndex--;
    x[myIndex].style.display = "block";
    mytimer = 999999999;


}

function plusSlides(){

 for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
if(myIndex == x.length-1){
  myIndex = 0;
  myIndex--;
  }

myIndex++;
    x[myIndex].style.display = "block";
   mytimer = 999999999;


}
*/
