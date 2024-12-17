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

        .table-hover tbody tr.selected {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <?php include '../controlador/header.php'; ?>
        <?php include '../modelo/conexion.php'; ?>
        <?php include '../modelo/fpdf/fpdf.php'; ?>
        <?php include '../controlador/slider.php'; ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="page-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="page-title">Gestión de Reportes</h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <button type="b
                                            utton" id="btnbuscar" class="btn btn-primary waves-effect waves-light">Generar Reporte</button>
                                        </div>
                                    </div>
                                </div>

                                <form id="reportForm" method="post" action="../modelo/generar_reporte.php">
                                    <input type="hidden" name="reporte_id" id="reporte_id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>De</strong></label>
                                                <input type="date" id="txtDe" name="txtDe" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Hasta</strong></label>
                                                <input type="date" id="txtHasta" name="txtHasta" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <?php
                                $reportes = [
                                    ['id' => 1, 'nombre' => 'Reporte de Compras'],
                                    ['id' => 2, 'nombre' => 'Reporte de Ventas'],
                                    ['id' => 3, 'nombre' => 'Reporte de Pagos Personal'],
                                ];
                                ?>
                                <div class="invoice-add-table">
                                    <div class="table-responsive">
                                        <table class='table table-hover' id="reportesTable">
                                            <thead>
                                                <tr>
                                                    <th scope='col'>N°</th>
                                                    <th scope='col'>Tipo de Comprobante</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($reportes as $reporte): ?>
                                                    <tr data-id="<?php echo $reporte['id']; ?>">
                                                        <td><?php echo $reporte['id']; ?></td>
                                                        <td><?php echo $reporte['nombre']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../controlador/scrips.php'; ?>

    <script src="../controlador/JScatalogos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedRow = null;

            $('#reportesTable tbody tr').on('click', function() {
                if (selectedRow) {
                    selectedRow.removeClass('selected');
                }
                $(this).addClass('selected');
                selectedRow = $(this);
                $('#reporte_id').val($(this).data('id'));
            });

            $('#btnbuscar').on('click', function() {
                if (!selectedRow) {
                    alert('Por favor, seleccione un reporte.');
                    return;
                }
                if (!$('#txtDe').val() || !$('#txtHasta').val()) {
                    alert('Por favor, seleccione las fechas de inicio y fin.');
                    return;
                }
                $('#reportForm').submit();
            });
        });
    </script>
</body>

</html>