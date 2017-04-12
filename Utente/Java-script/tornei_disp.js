/**
 * Created by gobbi on 12/04/2017.
 */
function torneo(id){
    var codice = "";
    $.ajax({
        type: "GET",
        url: "metodi/dati_torneo.php",
        data: "id_torneo="+id,
        success: function(risposta){
            var ogg = $.parseJSON(risposta);
            codice += "<div class='container-fluid'>";

            codice += "</div>";
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}