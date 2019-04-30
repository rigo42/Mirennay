<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                
                <?php if(isset($_SESSION['idEmpleado'])){  ?>
                    <!-- Solo administradores -->
                    <?php if($_SESSION['rolEmpleado'] == "admin"){  ?>
                    <li id="menuPedido" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>adminPedido"><i class="fas fa-clipboard"></i><span class="hide-menu">Pedidos</span></a></li>
                    
                    <?php if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente"){  ?>
                    <li id="menuProducto" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>adminAlmacen"><i class="fas fa-box-open"></i><span class="hide-menu">Almacen</span></a></li>
                    <?php } ?>
                    <li id="menuEmpleado" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>adminEmpleado"><i class="fas fa-user"></i><span class="hide-menu">Empleados</span></a></li>

                    <li id="menuEmpresa" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>adminEmpresa"><i class="fas fa-university"></i><span class="hide-menu">Empresas</span></a></li>

                    <li id="menuSubCategoria" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>adminSubCategoria"><i class="fas fa-clipboard"></i><span class="hide-menu">Sub categorias</span></a></li>

                    <li id="menuCategoria" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>adminCategoria"><i class="fas fa-clipboard"></i><span class="hide-menu">Categorias</span></a></li>
                    <?php } ?>
                    <!-- Solo administradores y empleados-->
                    <?php if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "gerente" || $_SESSION['rolEmpleado'] == "cajero"){ ?>
                    <li id="menuPuntoVenta" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>adminPuntoVenta"><i class="fa fa-shopping-cart"></i><span class="hide-menu">Punto venta</span></a></li>
                    <?php } ?>
                     <li id="" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>"><i class="fas fa-university"></i><span class="hide-menu">Mirennay</span></a></li>

                <?php } ?>
                
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->