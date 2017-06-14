/**
 * Created by gobbi on 13/06/2017.
 */
function stringiSidebar() {
    $('#sidebarLargo').toggle();
    $('#sidebarStretto').toggle();
    $('#page-wrapper').css("margin","0 0 0 50px");
    $('#sidebarLargo').css("width","50px");
    $('#sidebarStretto').css("width","50px");
    
}

function allargaSidebar() {
    $('#sidebarLargo').toggle();
    $('#sidebarStretto').toggle();
    $('#page-wrapper').removeAttr( 'style' );
    $('#sidebarLargo').removeAttr( 'style' );
    $('#sidebarStretto').removeAttr( 'style' );
    $('#sidebarStretto').css("display","none");
}