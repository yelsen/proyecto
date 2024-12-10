<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <?php include '../controlador/link.php'; ?>
    <style>
        .readonly-input[readonly] {
            background-color: #ffffff;
            border: 1px solid #ccc;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <?php include '../controlador/header.php'; ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">
                            <span>Menu Principal</span>
                        </li>
                        <li class="">
                            <a href="ventas.php"><i class="fas fa-holly-berry"></i><span> Ventas</span></a>
                        </li>
                        <li class="active">
                            <a href="compras.php"><i class="fas fa-holly-berry"></i><span> Compras</span></a>
                        </li>

                        <li class="menu-title">
                            <span>Reportes</span>
                        </li>
                        <li class="submenu ">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i><span> Reporte Financiero</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="" href="#">Rentabilidad</a></li>
                                <li><a class="" href="#">Ingresos</a></li>
                                <li><a class="" href="#">Egresos</a></li>
                                <li><a class="" href="#">Planilla</a></li>

                            </ul>
                        </li>
                        <li class="menu-title">
                            <span>Productos</span>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i><span> Productos</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="" href="#">Productos</a></li>
                                <li><a class="" href="catalogos.php">Catalogos</a></li>
                                <li><a class="" href="detalle_insumos.php">Regla Insumos</a></li>

                            </ul>
                        </li>


                        <li class="menu-title">
                            <span>Inventarios</span>
                        </li>
                        <li class="submenu ">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i><span> Inventarios</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="" href="insumos.php">Insumos</a></li>
                                <li><a class="" href="categorias.php">Categorias</a></li>
                                <li><a class="" href="sabores.php">Sabores</a></li>
                                <li><a class="" href="presentaciones.php">Presentaciones</a></li>
                            </ul>
                        </li>


                        <li class="menu-title">
                            <span>Proveedores</span>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i><span> Proveedores</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="" href="proveedores.php">Proveedores</a></li>
                                <li><a class="" href="empresas.php">Empresas</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">
                            <span>Personal</span>
                        </li>
                        <li class="submenu ">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i><span> Personal</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="" href="personal.php">Personal</a></li>

                            </ul>
                        </li>



                        <li class="menu-title">
                            <span>Administración</span>
                        </li>
                        <li class="submenu ">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i><span> Administración</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="" href="usuarios.php">Usuarios</a></li>
                                <li><a class="" href="roles.php">Roles</a></li>
                                <li><a class="" href="tipo_comprobante.php">Tipos de Comprobantes</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="row">
                    <!-- Panel Izquierdo -->
                    <div class="col-md-8">
                        <div class="row">
                            <!-- Primer  Panel -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="page-header ">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h3 class="page-title">Lista de Insumos a Ingresar</h3>
                                                </div>
                                                <div class="col-auto text-end float-end ms-auto download-grp">
                                                    <button type="button" id="btnAñadir" class="btn btn-primary waves-effect waves-light">Agregar Insumo</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3 position-relative">
                                                    <label for="field-3" class="form-label"><strong>Insumos</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" id="txtProductos" class="form-control" placeholder="Buscar Insumos" autocomplete="off"><a class="btn btn-secondary"><i class="fas fa-search"></i></a>
                                                    </div>
                                                    <ul class="list-group position-absolute w-100" id="listaProductos"
                                                        style="top: 100%; left: 0; max-height: 200px; overflow-y: auto; z-index: 1050; background: white; border: 1px solid #ddd;"></ul>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="field-3" class="form-label"><strong>Stock</strong></label>
                                                    <input type="number" id="txtStock" class="form-control" step="0.01" min="0">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Fecha de Vencimiento</strong></label>
                                                    <input type="date" id="txtFecha" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Précio de Compra</strong></label>
                                                    <input type="number" id="txtPrecio" class="form-control" step="0.01" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- notificacion -->
                                        <div id="miAlerta" class="alert alert-dismissible fade show" role="alert" style="display: none;">
                                            <strong id="alertTitulo"></strong> <span id="alertMensaje"></span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Segundo Panel -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- tabla con datos -->
                                        <div class="invoice-add-table">
                                            <div class="table-responsive">
                                                <table class="table table-center add-table-items">
                                                    <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>Insumos </th>
                                                            <th>Precio </th>
                                                            <th>Cantidad</th>
                                                            <th>Fecha de Caducidad</th>
                                                            <th class="text-end">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla-body"> </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Derecho -->
                    <div class="col-md-4">
                        <div class="row">
                            <!-- Panel Derecho Superior -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="page-header ">
                                            <h3 class="page-title">Detalle de Ingreso de Insumos</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Comprobante</strong></label>
                                                    <select class="form-select" id="cbComprobante" name="rol">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Número de Comprobante</strong></label>
                                                    <input type="text" id="txtNumero" class="form-control" placeholder="Número de Comprobante">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Costo de Transporte</strong></label>
                                                    <input type="number" id="txtTransporte" class="form-control" placeholder="0.00" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3 position-relative">
                                                    <label for="field-3" class="form-label"><strong>Proveedor</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" id="txtProveedor" class="form-control" placeholder="Buscar Proveedor" autocomplete="off"><a class="btn btn-secondary"><i class="fas fa-search"></i></a>
                                                    </div>
                                                    <ul class="list-group position-absolute w-100" id="listaProveedor"
                                                        style="top: 100%; left: 0; max-height: 200px; overflow-y: auto; z-index: 1050; background: white; border: 1px solid #ddd;"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="field-3" class="form-label"><strong>Monto Total</strong></label>
                                                    <input type="text" id="txtMonto_total" class="form-control" placeholder="0.00" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <button type="button" id="btnCancelar" class="btn btn-secondary waves-effect w-100">Cancelar</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <button type="button" id="btnAgregar" class="btn btn-primary waves-effect waves-light w-100">Registrar</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="page-header ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="page-title">Gestión de Compras</h3>
                                        </div>
                                    </div>
                                </div>
                                <!-- buscador -->
                                <div class="col">
                                    <div class="form-group input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" name="txbuscar" id="txbuscar" class="form-control" id="" placeholder="Buscar aqui">
                                    </div>
                                </div>
                                <!-- tabla con datos -->
                                <div id="tabla"></div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal eliminar-->
                <div class="modal fade" id="modalEliminar" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="modalEliminarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEliminarLabel">Confirmar Eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas eliminar este registro?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" id="btnEliminar" class="btn btn-danger">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>







            </div>
        </div>

    </div>

    <?php include '../controlador/scrips.php'; ?>
    <script src="../controlador/JScompras.js"></script>

</body>

</html>