<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <?php include '../controlador/link.php'; ?>
</head>

<body>
    <div class="main-wrapper">
        <?php include '../controlador/header.php'; ?>
        <?php include '../controlador/slider.php'; ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <!-- grafica -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="page-header ">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="page-title">Gestión de Insumos</h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <button type="button" title="Registrar datos" class="btn btn-primary w-100" data-bs-toggle="modal"
                                                data-bs-target="#modalAgregar">Registrar</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- notificacion -->
                                <div id="miAlerta" class="alert alert-dismissible fade show" role="alert" style="display: none;">
                                    <strong id="alertTitulo"></strong> <span id="alertMensaje"></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

                <!-- Modal añadir-->
                <div class="modal fade" tabindex="-1" id="modalAgregar" data-bs-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Registro de Insumos</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="field-3" class="form-label">Insumos</label>
                                            <input type="text" id="txtInsumos" class="form-control" placeholder="Insumos">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnCancelar" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" id="btnAgregar" class="btn btn-primary waves-effect waves-light">Guardar Registro</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal editar-->
                <div class="modal fade" id="modalEditar" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Editar Insumos</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="field-3" class="form-label">Insumos</label>
                                            <input type="text" id="txtInsumosE" class="form-control" placeholder="Insumos">
                                            <input type="hidden" id="txtid" class="form-control">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnCancelar" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" id="btnModificar" class="btn btn-primary waves-effect waves-light">Guardar Cambio</button>
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

                <!-- Modal Ver Detalles -->
                <div class="modal fade" id="modalDetalles" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="modalDetallesLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDetallesLabel">Detalles del Registro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="detalleId" class="form-label">ID</label>
                                    <input type="text" id="detalleId" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="detalleRol" class="form-label">Insumos</label>
                                    <input type="text" id="detalleInsumos" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php include '../controlador/scrips.php'; ?>

    <script src="../controlador/JSinsumos.js"></script>
</body>

</html>