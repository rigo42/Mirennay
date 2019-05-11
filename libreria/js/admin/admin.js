//Inifinity free
var URL = "http://mirennay.epizy.com/"; 

//000WebHost
//var URL = "https://fb-foto-movile.000webhostapp.com/"; 

//MiPropia
//var URL = "http://mirennay.mipropia.com/"; 

//localhost
//var URL = "http://localhost/mirennayv3/"; 

$(document).ready(function(){

    //Tablas dinamicas
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

    //Reporte
    $("#reporte").click(function(e){
        e.preventDefault();
        var url = $(this).attr("data-url");
        reporte(url);
    });


});

//SIRVE: Para setearle un titulo a la pagina
//PORQUE: Por que el usaurio identificara en que pagina esta si lee el tittle
function tittlePage(id,titulo){
    $(id).addClass("selected");
    $("#titulo").html(titulo);
}

function notificacion(tipo,mensaje){
    if(tipo == "success"){
        toastr.success(mensaje);
    }if(tipo == "info"){
        toastr.info(mensaje);
    }if(tipo == "warning"){
        toastr.warning(mensaje);
    }if(tipo == "error"){
        toastr.error(mensaje);
    }
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

function reporte(url){
    $.ajax({
        type: "POST",
        url: URL+url,
        data: {
        },
        cache: false,
        beforeSend: function() {
            //$('#tablaDinamica').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
             $('#salidaReporte').html(data);
        }
    });
}

function filePreview(input,id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(id).html('');
            $(id+" + img").remove();
            $(id).after('<img class="col-md-2" src="'+e.target.result+'" />');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function cantidadColor1(inicioCantidad,cantidadColor){
    $.ajax({
        type: "POST",
        url: URL+"adminAlmacen/cantidadDetalle",
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
        url: URL+'adminAlmacen/productoNuevo',
        data:datos,
        contentType: false,
        processData : false,
        beforeSend: function() { 
            $('#gif').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data) {
            if(data == 1){
                $('#gif').html('');
                notificacion("success","Producto agregado correctamente");
                location=URL+"adminAlmacen";
            }else{
                $('#gif').html('');
                notificacion("error",data);
            }
        }
    });
}

function productoEditar(datos){
    $.ajax({
        type:'POST',
        url: URL+'adminAlmacen/productoEditar',
        data:datos,
        contentType: false,
        processData : false,
        beforeSend: function() {
            $('#gif').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data) {
           if(data == 1){
                $('#gif').html('');
                notificacion("success","Producto modificado correctamente");
                location=URL+"adminAlmacen";
            }else{
                $('#gif').html('');
                notificacion("error",data);
            }
        }
    });
}

function  productoActivo(idProducto,activo){
    $.ajax({
        type: "POST",
        url: URL+"adminAlmacen/productoActivo",
        data: {
            idProducto:idProducto,
            activo:activo
        },
        cache: false,
        beforeSend: function() {
            //$('#tablaDinamica').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data === ""){
                location=URL+'adminAlmacen';
            }else{
                notificacion("error",data);
                
            }
        }
    });
}

function eliminarProductoDetalle(idProductoDetalle){
    $.ajax({
        type: "POST",
        url: URL+"adminAlmacen/eliminarProductoDetalle",
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

function eliminarImagen(idProductoDetalle,atributo,imagen){
    $.ajax({
        type: "POST",
        url: URL+"adminAlmacen/eliminarImagen",
        data: {
            idProductoDetalle:idProductoDetalle,
            atributo:atributo,
            imagen:imagen
        },
        cache: false,
        beforeSend: function() {
            //$('#tablaDinamica').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data == 1){
                notificacion("success","Imagen eliminada");
            }else{
                notificacion("error",data);
            }
        }
    });
}

function modalDireccion(folio){
    $.ajax({
        type: "POST",
        url: URL+"adminPedido/modalDireccion",
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
        url: URL+"adminPedido/obtenerPedido",
        data: {
            folio:folio
        },
        cache: false,
        beforeSend: function(){
            $('#enviarProducto').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            $('#enviarProducto').html("Listo!");
            location=URL+"adminPedido";
        }
    });
}

function ventanaCart(){
    $.ajax({
        type: "POST",
        url: URL+"adminPuntoVenta/ventanaCart",
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
        url: URL+"adminPuntoVenta/addCart",
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
                notificacion("error",data);
            }
            ventanaCart();
        }
    });
}

function deleteCart(codigo){
    $.ajax({
        type: "POST",
        url: URL+"adminPuntoVenta/deleteCart",
        data: {
            codigo:codigo
        },
        cache: false,
        beforeSend: function(){
            $('#ventanaCart').html('<img src=" '+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                //notificacion("error",data);
                ventanaCart();
            }
            ventanaCart();
        }
    });
}

function dropCart(codigo){
    $.ajax({
        type: "POST",
        url: URL+"adminPuntoVenta/dropCart",
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
        url: URL+"adminPuntoVenta/confirmarPago",
        data: {
        },
        cache: false,
        beforeSend: function(){
            $('#cambioPago').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            $('#cambioPago').html('');
            ticket();
            //window.location.reload(true); 
        }
    });
}

function ticket(){
    $("#modal").modal("hide");
    window.open(URL+"adminPuntoVenta/ticket", "Ticket", "width=300, height=500");
    window.location.reload(true); 
}

function formEmpresaEditar(datos){
     $.ajax({
        type: "POST",
        url: URL+"adminEmpresa/formEmpresaEditar",
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
                    notificacion("error",data);
                }
            }else{
                 notificacion("success","Listo");
            }
        }
    });
}

function formEmpresaNuevo(datos){
    $.ajax({
        type: "POST",
        url: URL+"adminEmpresa/formEmpresaNuevo",
        data: datos,
        cache: false,
        beforeSend: function() {
            $('#agregar').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                if(data == 1){
                    notificacion("warning","Utilize un correo valido");
                }else{
                   notificacion("error",data);
                }
            }else{
                notificacion("success","Listo");
            }
        }
    });
}

function formEmpleadoServlet(datos){
    $.ajax({
        type: "POST",
        url: URL+"adminEmpleado/empleadoServlet",
        data: datos,
        cache: false,
        beforeSend: function() {
            $('#mensajeEmpleado').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                if(data == 1){
                    notificacion("warning","Utilize un correo valido");
                    $('#mensajeEmpleado').html('');
                }else if(data == 2){
                    $('#mensajeEmpleado').html('');
                    notificacion("warning","Celular invalido");
                }else if(data == 3){
                   $('#mensajeEmpleado').html('');
                   notificacion("warning","Salario invalido");
                }else if(data == 4){
                    $('#mensajeEmpleado').html('');
                    notificacion("success","correo enviado");
                }else if(data == 5){
                    $('#mensajeEmpleado').html('');
                    notificacion("success","Empleado modificado");
                }else{
                    $('#mensajeEmpleado').html('');
                    notificacion("error",data);
                }
            }
        }
    });
}

function formSubCategoriaServlet(datos){
    $.ajax({
        type: "POST",
        url: URL+"adminSubCategoria/subCategoriaServlet",
        data: datos,
        cache: false,
        beforeSend: function() {
            $('#gif').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                if(data == 1){
                    notificacion("success","Sub categoria agregada");
                    $('#gif').html('Listo');
                }else if(data == 2){
                    $('#gif').html('Listo');
                    notificacion("success","Sub categoria modificada");
                }else{
                    $('#gif').html('Error');
                    notificacion("error",data);
                }
            }
        }
    });
}

function formCategoriaServlet(datos){
    $.ajax({
        type: "POST",
        url: URL+"adminCategoria/categoriaServlet",
        data: datos,
        cache: false,
        contentType: false,
        processData : false,
        beforeSend: function() {
            $('#gif').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data != ""){
                if(data == 1){
                    notificacion("success","Categoria agregada");
                    $('#gif').html('Listo');
                }else if(data == 2){
                    $('#gif').html('Listo');
                    notificacion("success","Categoria modificada");
                    location=URL+"adminCategoria";
                }else{
                    $('#gif').html('Error');
                    notificacion("error",data);
                }
            }
        }
    });
}

function iniciarSesion(datos){
    $.ajax({
        type: "POST",
        url: URL+"adminLogin/iniciarSesion",
        data: datos,
        cache: false,
        beforeSend: function() {
            $('#mensajeAdminLogin').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data == 1){
                window.location=URL+"adminAlmacen";
            }else if(data == 2){
                $('#mensajeAdminLogin').html('Usuario o contraseña incorrecto');
            }else{
                notificacion("error",data);
            }
        }
    });
}

function cerrarSesion(){
    $.ajax({
        type: "POST",
        url: URL+"adminLogin/cerrarSesion",
        data: {},
        cache: false,
        success: function(data){
            window.location=URL+"adminLogin";
        }
    });
}

function activarCodigoVerificacion(datos){
    $.ajax({
        type: "POST",
        url: URL+"adminLogin/activarCodigoVerificacion",
        data: datos,
        cache: false,
        beforeSend: function() {
            $('#mensajeRecuperarPassword').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data == 1){
                $('#mensajeRecuperarPassword').html('');
                notificacion("success","Revisa tu correo electronico.");
            }else if(data == 2){
                $('#mensajeRecuperarPassword').html('');
                notificacion("warning","Correo invalido.");
            }else if(data == 3){
                $('#mensajeRecuperarPassword').html('');
                notificacion("warning","Correo no encontrado en el sistema.");
            }else{
                $('#mensajeRecuperarPassword').html(data);
                notificacion("error",data);
            }
        }
    });
}

function cambiarPassword(password,correo){
    $.ajax({
        type: "POST",
        url: URL+"adminLogin/cambiarPassword",
        data: {
            password:password,
            correo:correo
        },
        cache: false,
        beforeSend: function() {
            $('#cargarPassword').html('<img src="'+URL+'libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data){
            if(data == 1){
                $('#cargarPassword').html('');
                notificacion("success","¡Listo! vuelve a iniciar sesión.");
                location=URL+"adminLogin";
            }else{
                $('#cargarPassword').html('');
                notificacion("error",data);
            }
        }
    });
}

