<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <?php include '../controlador/link.php'; ?>
    <style>
        .form-select:focus {
            border-color: #0d6efd;
            outline: none;
            box-shadow: none;
        }
    </style>

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
                                            <h3 class="page-title">Gestión de Usuarios</h3>
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
                                        <input type="text" name="txbuscar" id="txbuscar" class="form-control" placeholder="Buscar aqui">
                                    </div>
                                </div>

                                <!-- tabla con datos -->
                                <div id="tabla"></div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal añadir-->
                <div class="modal fade" tabindex="-1" id="modalAgregar" role="dialog" data-bs-backdrop="static" aria-labelledby="myModalLabel" style="display: none;">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Registro de Usuarios</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label">Buscar Persona</label>
                                            <div class="input-group">
                                                <input type="text" id="txtDNI" class="form-control" placeholder="Buscar por DNI o Nombres">
                                                <a class="btn btn-primary"><i class="fas fa-search"></i></a>
                                            </div>
                                            <ul class="list-group position-absolute w-100" id="lista"
                                                style="top: 100%; left: 0; max-height: 200px; overflow-y: auto;"></ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Usuario</label>
                                            <input type="text" id="txtUsuario" class="form-control" placeholder="Usuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input type="text" id="txtContraseña" class="form-control" placeholder="Contraseña">
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
                <div class="modal fade" tabindex="-1" id="modalEditar" role="dialog" data-bs-backdrop="static" aria-labelledby="myModalLabel" style="display: none;">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Registro de Personales</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label">Buscar Persona</label>
                                            <div class="input-group">
                                                <input type="text" id="txtDNIE" class="form-control" placeholder="Buscar por RUC o Nombres de Empresas">
                                                <a class="btn btn-primary"><i class="fas fa-search"></i></a>
                                            </div>
                                            <ul class="list-group position-absolute w-100" id="listaE"
                                                style="top: 100%; left: 0; max-height: 200px; overflow-y: auto;"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Usuario</label>
                                            <input type="text" id="txtUsuarioE" class="form-control" placeholder="Usuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input type="text" id="txtContraseñaE" class="form-control" placeholder="Contraseña">
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
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item form-group ">
                                        <strong>DNI: </strong>
                                        <span id="dniV"></span>
                                    </li>
                                    <li class="list-group-item form-group ">
                                        <strong>Apellidos y Nombres: </strong>
                                        <span id="ape_nomV"></span>
                                    </li>
                                    <li class="list-group-item form-group ">
                                        <strong>Usuario: </strong>
                                        <span id="usuarioV"></span>
                                    </li>
                                    <li class="list-group-item form-group ">
                                        <strong>Contraseña: </strong>
                                        <span id="contraseñaV"></span>
                                    </li>

                                </ul>
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

    <script src="../controlador/JSusuarios.js"></script>



</body>

</html>