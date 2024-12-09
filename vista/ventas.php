<!DOCTYPE html>
<html lang="en">

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
        <?php include '../controlador/slider.php'; ?>
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
                                            <h3 class="page-title">Venta de Productos</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 position-relative">
                                                    <label for="field-3" class="form-label"><strong>Productos</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" id="txtProductos" class="form-control" placeholder="Buscar Productos">
                                                        <a class="btn btn-secondary"><i class="fas fa-search"></i></a>
                                                    </div>
                                                    <ul class="list-group position-absolute w-100" id="lista" style="top: 100%; left: 0; max-height: 200px; overflow-y: auto;"></ul>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label for="field-3" class="form-label"><strong>Stock</strong></label>
                                                    <input type="text" id="txtStock" class="form-control" placeholder="0" readonly>
                                                </div>
                                            </div>
                                            <input type="hidden" id="txtPrecio" class="form-control">

                                            <div class="col-md-4">
                                                <div class="mb-3 position-relative">
                                                    <label for="field-3" class="form-label"><strong>Cantidad</strong></label>
                                                    <div class="input-group">
                                                        <input type="number" id="txtCantidad" class="form-control" step="0.01" min="0">

                                                        <a class="btn btn-primary"><i class="fas fa-plus-circle"></i> Agregar</a>
                                                    </div>

                                                </div>
                                            </div>




                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Segundo Panel -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- tabla con datos -->
                                        <div id="tabla"></div>

                                        <div class="invoice-add-table">
                                            <div class="table-responsive">
                                                <table class="table table-center add-table-items">
                                                    <thead>
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Producto</th>
                                                            <th>Precio</th>
                                                            <th>Cantidad</th>
                                                            <th>Total</th>
                                                            <th class="text-end">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla-body"> </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="field-3" class="form-label"><strong>Monto</strong></label>
                                                    <input type="text" id="txtMonto" class="form-control" placeholder="0.00" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="field-3" class="form-label"><strong>IGV</strong></label>
                                                    <input type="text" id="txtIGV" class="form-control" placeholder="0.00" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="field-3" class="form-label"><strong>Monto Total</strong></label>
                                                    <input type="text" id="txtMonto_total" class="form-control" placeholder="0.00" readonly>
                                                </div>
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
                                            <h3 class="page-title">Detalle de Venta</h3>
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
                                                    <label class="form-label"><strong>Número</strong></label>
                                                    <input type="text" id="txtNumero" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Pagar</strong></label>
                                                    <input type="number" id="txtPagar" class="form-control" step="0.01" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Vuelto</strong></label>
                                                    <input type="text" id="txtVuelto" class="form-control" readonly>
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




                <!-- Modal añadir-->
     



            </div>
        </div>

    </div>

    <?php include '../controlador/scrips.php'; ?>
    <script src="../controlador/JSventas.js"></script>


</body>

</html>