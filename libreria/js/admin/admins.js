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
            var search = $(this).val();
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
            $('#tablaDinamica').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
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
           location=URL+"almacen";
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
            location=URL+"almacen";
        }
    });
}

function  productoActivo(idProducto,activo){
    $.ajax({
        type: "POST",
        url: URL+"almacen/productoActivo",
        data: {
            idProducto:idProducto,
            activo:activo
        },
        cache: false,
        beforeSend: function() {
            //$('#tablaDinamica').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
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
            //$('#tablaDinamica').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
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
            //$('#tablaDinamica').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
             //$('#tablaDinamica').html(data);
        }
    });
}

function modalDireccion(folio){
    $.ajax({
        type: "POST",
        url: URL+"pedido/modalDireccion",
        data: {
            folio:folio
        },
        cache: false,
        beforeSend: function() {
           // $('#tablaDinamica').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
             $('#modalDireccion').html(data);
        }
    });
}

function obtenerPedido(folio){
    $.ajax({
        type: "POST",
        url: URL+"pedido/obtenerPedido",
        data: {
            folio:folio
        },
        cache: false,
        beforeSend: function(){
            $('#enviarProducto').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            $('#enviarProducto').html("Listo!");
            location=URL+"pedido/admin";
        }
    });
}

function ventanaCart(){
    $.ajax({
        type: "POST",
        url: URL+"puntoVenta/ventanaCart",
        data: {
        },
        cache: false,
        beforeSend: function(){
            $('#ventanaCart').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            $('#ventanaCart').html(data);
        }
    });
}

function addCart(search,cantidadPedido){
    $.ajax({
        type: "POST",
        url: URL+"puntoVenta/addCart",
        data: {
            codigo:search,
            cantidadPedido:cantidadPedido
        },
        cache: false,
        beforeSend: function(){
            $('#ventanaCart').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                alert(data);
                ventanaCart();
            }
            ventanaCart();
        }
    });
}

function deleteCart(codigo){
    $.ajax({
        type: "POST",
        url: URL+"puntoVenta/deleteCart",
        data: {
            codigo:codigo
        },
        cache: false,
        beforeSend: function(){
            $('#ventanaCart').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                alert(data);
                ventanaCart();
            }
            ventanaCart();
        }
    });
}

function dropCart(codigo){
    $.ajax({
        type: "POST",
        url: URL+"puntoVenta/dropCart",
        data: {
        },
        cache: false,
        beforeSend: function(){
            $('#ventanaCart').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            ventanaCart();
        }
    });
}

function confirmarPago(){
    $.ajax({
        type: "POST",
        url: URL+"puntoVenta/confirmarPago",
        data: {
        },
        cache: false,
        beforeSend: function(){
            $('#cambioPago').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            window.location.reload(true); 
        }
    });
}

function formEmpresaEditar(datos){
     $.ajax({
        type: "POST",
        url: URL+"empresa/formEmpresaEditar",
        data: datos,
        cache: false,
        beforeSend: function() {
            $('#modificar').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                if(data == 1){
                    $('#modificar').html('Utilize un correo valido');
                }else{
                    alert(data);
                }
            }else{
                $('#modificar').html('Listo');
            }
        }
    });
}

function formEmpresaNuevo(datos){
     $.ajax({
        type: "POST",
        url: URL+"empresa/formEmpresaNuevo",
        data: datos,
        cache: false,
        beforeSend: function() {
            $('#agregar').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                if(data == 1){
                    $('#agregar').html('Utilize un correo valido');
                }else{
                    alert(data);
                }
            }else{
                $('#agregar').html('Listo');
            }
        }
    });
}
