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

function filePreview(input,id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(id).html("");
            $(id).after('<img class="col-md-2" src="'+e.target.result+'" />');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function cantidadColor1(inicioCantidad,cantidadColor){
    $.ajax({
        type: "POST",
        url: URL+"almacen/cantidadDetalle",
        data: {
            inicioCantidad:inicioCantidad,
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

function productoEditar(datos){
    $.ajax({
        type:'POST',
        url: URL+'almacen/productoEditar',
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

function  eliminarProducto(idProducto){
    $.ajax({
        type: "POST",
        url: URL+"almacen/eliminarProducto",
        data: {
            idProducto:idProducto
        },
        cache: false,
        beforeSend: function() {
            //$('#tablaDinamica').html('<img src="libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            location=URL+'almacen';
        }
    });
}

function eliminarProductoDetalle(idProductoDetalle){
    $.ajax({
        type: "POST",
        url: URL+"almacen/eliminarProductoDetalle",
        data: {
            idProductoDetalle:idProductoDetalle
        },
        cache: false,
        beforeSend: function() {
            //$('#tablaDinamica').html('<img src="libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
             //$('#tablaDinamica').html(data);
        }
    });
}

function eliminarImagen(idProductoDetalle,atributo){
    $.ajax({
        type: "POST",
        url: URL+"almacen/eliminarImagen",
        data: {
            idProductoDetalle:idProductoDetalle,
            atributo:atributo
        },
        cache: false,
        beforeSend: function() {
            //$('#tablaDinamica').html('<img src="libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
             //$('#tablaDinamica').html(data);
        }
    });
}



