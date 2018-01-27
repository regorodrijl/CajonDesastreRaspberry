$(document).ready(function () {
    $('#localizacion').hide();
    $('#contacto').hide();

    console.log("Preparado btn!");
    $("#enlace-cabecera-local").on('click', function () {
        console.log("localizacion");
        $('.cuerpoPrincipal').css("display", "none");
        $('#localizacion').css("display", "block");
        $('#contacto').css("display", "none");
        modal.style.display = "none";
        $('#nav-icon1').removeClass('open');
    });
    $("#enlace-cabecera-contact").on('click', function () {
        console.log("contacto");
        $('.cuerpoPrincipal').css("display", "none");
        $('#localizacion').css("display", "none");
        $('#contacto').css("display", "block"); 
        modal.style.display = "none";
        $('#nav-icon1').removeClass('open');
    });
});


$(document).ready(function () {
    $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').click(function () {
        $(this).toggleClass('open');
    });
});

//MODAL
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("nav-icon1");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal 
btn.onclick = function () {
    if (modal.style.display === "block") {
        modal.style.display = "none";
    } else {
        modal.style.display = "block";
        $('.menu').css("display", "block");
        $('#nav-icon1').css('z-index', 1);
    }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
        $('#nav-icon1').removeClass('open');
    }
}