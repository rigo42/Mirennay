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
                    <li id="menuPedido" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>pedido/admin" aria-expanded="false"><i class="fas fa-clipboard"></i><span class="hide-menu">Pedidos</span></a></li>

                    <li id="menuProducto" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>almacen" aria-expanded="false"><i class="fas fa-box-open"></i><span class="hide-menu">Almacen</span></a></li>

                    <li id="menuEmpresa" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>empresa" aria-expanded="false"><i class="fas fa-university"></i><span class="hide-menu">Empresas</span></a></li>
                    <?php } ?>
                    <!-- Solo administradores y empleados-->
                    <?php if($_SESSION['rolEmpleado'] == "admin" || $_SESSION['rolEmpleado'] == "empleado"){ ?>
                    <li id="menuPuntoVenta" class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo URL ?>PuntoVenta" aria-expanded="false"><i class="fa fa-shopping-cart"></i><span class="hide-menu">Punto venta</span></a></li>
                    <?php } ?>

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