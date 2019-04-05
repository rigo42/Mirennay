//Inifinity free
//var URL = "http://mirennay.epizy.com/"; 

//000WebHost
//var URL = "https://fb-foto-movile.000webhostapp.com/"; 

//localhost
var URL = "http://localhost/mirennayv3/"; 

$(document).ready(function(){

    $(".activo").click(function(e){
        e.preventDefault();
        var search = $("input[name='search']").val();
        var url = $("#tablaDinamica").attr("data-url");
        tablaDinamica(search,url,1);
    });

    $(".inactivo").click(function(e){
        e.preventDefault();
        var search = $("input[name='search']").val();
        var url = $("#tablaDinamica").attr("data-url");
        tablaDinamica(search,url,0);
    });

    $("input[name='search']").keyup(function(e){
        e.preventDefault();
        if(e.keyCode == 13){
            var search = $("input[name='search']").val();
            var url = $("#tablaDinamica").attr("data-url");
            tablaDinamica(search,url,"1");
        }
    });


});
//SIRVE: Para setearle un titulo a la pagina
//PORQUE: Por que el usaurio identificara en que pagina esta si lee el tittle
function tittlePage(id,titulo){
    $(id).addClass("selected");
    $("#titulo").html(titulo);
}
    
function tablaDinamica(search,url,activo){
    $.ajax({
        type: "POST",
        url: URL+url,
        data: {
            search:search,
            activo:activo
        },
        cache: false,
        beforeSend: function() {
            $('#tablaDinamica').html('<img src="libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
             $('#tablaDinamica').html(data);
        }
    });
}

function cantidadColor1(cantidadColor){
    $.ajax({
        type: "POST",
        url: URL+"almacen/cantidadDetalle",
        data: {
            cantidadColor:cantidadColor
        },
        cache: false,
        beforeSend: function() {
        },
        success: function(data) {
           $("#cantidadColor").html(data);
        }
    });
}

function productoNuevo(datos){
    $.ajax({
        type:'POST',
        url: URL+'almacen/productoNuevo',
        data:datos,
        contentType: false,
        processData : false,
        beforeSend: function() {
        },
        success: function(data) {
           alert(data);
        }
    });
}