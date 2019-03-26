var URL = "http://localhost/mirennayv3/"; 

$(document).ready(function(){
	//Load page
    $("#loader").fadeOut("fast"); 

    $(".fa-plus").click(function(e){
      e.preventDefault();
      var localizacion = $(this).attr("data-localizacion");
      alert(localizacion);
     // location="producto/nuevo";
    });
    $(".fa-times").click(function(e){
      e.preventDefault();
      var search = $("input[name='search']").val();
      var url = $("#tablaDinamica").attr("data-url");
      tablaDinamica(search,"0",url);  
    });
    $(".fa-check").click(function(e){
      e.preventDefault();
      var search = $("input[name='search']").val();
      var url =$("#tablaDinamica").attr("data-url");
      tablaDinamica(search,"1",url);  
    });
    $("input[name='search']").keyup(function(e){
      e.preventDefault();
      if(e.which == 13){
        var search = $(this).val();
        var url = $("#tablaDinamica").attr("data-url");
        tablaDinamica(search,"",url);  
      }
    }); 

});

function tablaDinamica(search, activo, metodo) {
    $.ajax({
        type: "POST",
        url: URL+metodo,
        data: {
          search:search,
          activo:activo
        },
        cache: false,
    beforeSend: function() {
            $('#tablaDinamica').html('<img src="libreria/img/espere.gif" alt="reload" width="20" height="20">');
        },
        success: function(data) {
            $("#tablaDinamica").html(data);
        }
    });
}