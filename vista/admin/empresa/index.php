<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Empresas</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo URL ?>">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Empresas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="el-card-item">
            <div class="page-breadcrumb">
                <div class="row form-group">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Buscar...">
                            <div class="input-group-append activo">
                                <span class="input-group-text" title="Ver activos" style="cursor: pointer;"><i class="fas fa-check-circle"></i></span>
                            </div>
                            <div class="input-group-append inactivo">
                                <span class="input-group-text" title="Ver inactivos" style="cursor: pointer;"><i class="fas fa-window-close"></i></span>
                            </div>
                            <div class="input-group-append">
                                <a href="<?php echo URL ?>empresa/nuevo" class="input-group-text" title="Nuevo" style="cursor: pointer;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row el-element-overlay" id="tablaDinamica" data-url="empresa/mostrar">
        </div>
    </div>

</div>

<script type="text/javascript">
    tittlePage("#menuEmpresa","Empresas");
    tablaDinamica("","empresa/mostrar",1);
</script>