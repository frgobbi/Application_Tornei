/**
 * Created by gobbi on 13/06/2017.
 */
function stringiSidebar() {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "../Librerie/PHP/cambioDimensione.php",
            data: "dim=on",
            dataType: "html",
            success: function () {
                $('#sidebarLargo').toggle();
                $('#sidebarStretto').toggle();
                $('#page-wrapper').css("margin", "0 0 0 50px");
                $('#sidebarLargo').css("width", "50px");
                $('#sidebarStretto').css("width", "50px");
            },
            error: function () {
                alert("Chiamata fallita, si prega di riprovare...");
            }
        });
    });
}

function allargaSidebar() {
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "../Librerie/PHP/cambioDimensione.php",
            data: "dim=off",
            dataType: "html",
            success: function () {
                $('#sidebarLargo').toggle();
                $('#sidebarStretto').toggle();
                $('#page-wrapper').removeAttr('style');
                $('#sidebarLargo').removeAttr('style');
                $('#sidebarStretto').removeAttr('style');
                $('#sidebarStretto').css("display", "none");
            },
            error: function () {
                alert("Chiamata fallita, si prega di riprovare...");
            }
        });
    });
}