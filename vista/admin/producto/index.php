<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3> Productos <small> Mirennay rifa</small> </h3>
      </div>

      <div class="title_right">
          
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
         
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar producto...">
            <!--
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">>:v</button>
            </span>
            -->
          </div>
        </div>

      </div>
       
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Productos <small> :3 </small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li title="Agregar nuevo producto"><a><i class="fa fa-plus" data-localizacion="Producto/nuevo"></i></a>
              </li>
              <li title="Ver inactivos"><a><i class="fa fa-times"></i></a>
              </li>
              <li title="Ver activos"><a><i class="fa fa-check"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <div class="row" id="tablaDinamica" data-url="Producto/producto">

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<script type="text/javascript">
  $(document).ready(function(){

    tablaDinamica("","1","Producto/producto"); 

  });
</script>
