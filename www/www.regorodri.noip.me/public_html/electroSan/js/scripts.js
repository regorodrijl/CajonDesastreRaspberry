$(document).ready(function () {

    $(".mensaje").css("display", "none");
    $(".contacto").css("display", "none");
    $("#accueil").click(function () {
        $(".home").css("display", "block");
        $(".mensaje").css("display", "none");
        $(".contacto").css("display", "none");

        $("#accueil").addClass("active");
        $("#mensaje").removeClass("active");
        $("#devis").removeClass("active");
    });
    $("#contacter").click(function () {
        $(".home").css("display", "none");
        $(".mensaje").css("display", "none");
        $(".contacto").css("display", "block");

        $("#accueil").removeClass("active");
        $("#devis").removeClass("active");
        $("#contacter").addClass("active");
    });
    $("#devis").click(function () {
        $(".home").css("display", "none");
        $(".mensaje").css("display", "block");
        $(".contacto").css("display", "none");

        $("#accueil").removeClass("active");
        $("#devis").addClass("active");
        $("#contacter").removeClass("active");
    });
});