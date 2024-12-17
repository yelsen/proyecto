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

        #chartTypeSelector {
            margin-bottom: 20px;
        }

        #totalCompras {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <?php include '../controlador/header.php'; ?>
        <?php include '../modelo/conexion.php'; ?>
        <?php include '../modelo/fpdf/fpdf.php'; ?>
        <?php include '../controlador/slider.php'; ?>

        <?php
        // Conexión a la base de datos (ajusta estos valores según tu configuración)
        include("../modelo/conexion.php");

        // Obtener fechas del formulario si se han enviado
        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-d', strtotime('-30 days'));
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');

        // Consulta SQL con filtro de fechas
        $query = "SELECT 
                    c.fecha_ingresoC AS fecha_compras,
                    e.nombre_empresa AS empresa,
                    SUM(c.monto_ingresoC) AS total_compras
                FROM compras AS c
                INNER JOIN proveedores AS p ON p.idproveedor = c.fk_idproveedor
                INNER JOIN empresas AS e ON e.idempresa = p.fk_idempresa
                WHERE c.cond_comp = 0
                AND c.fecha_ingresoC BETWEEN ? AND ?
                GROUP BY e.nombre_empresa, c.fecha_ingresoC
                ORDER BY c.fecha_ingresoC";

        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }

        $conexion->close();

        // Procesar datos para el gráfico
        $empresas = array_unique(array_column($datos, 'empresa'));
        $fechas = array_unique(array_column($datos, 'fecha_compras'));
        sort($fechas);

        $datasets = array();
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
        foreach ($empresas as $index => $empresa) {
            $data = array();
            foreach ($fechas as $fecha) {
                $total = 0;
                foreach ($datos as $dato) {
                    if ($dato['empresa'] == $empresa && $dato['fecha_compras'] == $fecha) {
                        $total = $dato['total_compras'];
                        break;
                    }
                }
                $data[] = $total;
            }
            $datasets[] = array(
                'label' => $empresa,
                'data' => $data,
                'fill' => false,
                'borderColor' => $colors[$index % count($colors)],
                'backgroundColor' => $colors[$index % count($colors)],
                'tension' => 0.1
            );
        }

        $datosJSON = json_encode($datasets);
        $fechasJSON = json_encode($fechas);
        ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="page-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="page-title">Gestión de Gráficos</h3>
                                        </div>
                                    </div>
                                </div>
                                <form action="" method="GET" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="fecha_inicio" class="form-label"><strong>Fecha de inicio:</strong></label>
                                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="fecha_fin" class="form-label"><strong>Fecha de Fin:</strong></label>
                                            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary w-100">
                                                Filtrar
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="chartTypeSelector" class="form-label"><strong>Tipo de Gráfico:</strong></label>
                                        <select id="chartTypeSelector" class="form-select">
                                            <option value="line">Línea</option>
                                            <option value="bar">Barras</option>
                                            <option value="pie">Circular</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dataGrouping" class="form-label"><strong>Agrupación de Datos:</strong></label>
                                        <select id="dataGrouping" class="form-select">
                                            <option value="daily">Diario</option>
                                            <option value="weekly">Semanal</option>
                                            <option value="monthly">Mensual</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="bg-white p-4 rounded-lg shadow">
                                    <div class="chart-container">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>

                                <div id="totalCompras" class="mt-4"></div>

                                <div class="text-center mt-4">
                                    <button id="downloadPDF" class="btn btn-secondary">Descargar PDF</button>
                                    <button id="downloadCSV" class="btn btn-secondary">Descargar CSV</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chartData = {
        labels: <?php echo $fechasJSON; ?>,
        datasets: <?php echo $datosJSON; ?>
    };
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Estadísticas de Compras por Empresa'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total de Compras'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Fecha de Compra'
                }
            }
        }
    };
    var myChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: chartOptions
    });

    function updateChartType() {
        myChart.destroy();
        myChart = new Chart(ctx, {
            type: document.getElementById('chartTypeSelector').value,
            data: chartData,
            options: chartOptions
        });
    }

    document.getElementById('chartTypeSelector').addEventListener('change', updateChartType);

    function calculateTotalCompras() {
        var total = chartData.datasets.reduce((sum, dataset) => {
            return sum + dataset.data.reduce((a, b) => a + b, 0);
        }, 0);
        document.getElementById('totalCompras').textContent = 'Total de Compras: $' + total.toFixed(2);
    }

    calculateTotalCompras();

    document.getElementById('dataGrouping').addEventListener('change', function() {
        // Aquí iría la lógica para reagrupar los datos según la selección
        // Por ahora, solo mostraremos un mensaje
        alert('Funcionalidad de agrupación en desarrollo');
    });

    document.getElementById('downloadPDF').addEventListener('click', function() {
        html2canvas(document.querySelector("#myChart")).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jspdf.jsPDF();
            pdf.addImage(imgData, 'PNG', 10, 10);
            pdf.save("estadisticas_compras.pdf");
        });
    });

    document.getElementById('downloadCSV').addEventListener('click', function() {
        var csv = 'Fecha,';
        chartData.datasets.forEach(dataset => {
            csv += dataset.label + ',';
        });
        csv += '\n';

        chartData.labels.forEach((label, index) => {
            csv += label + ',';
            chartData.datasets.forEach(dataset => {
                csv += dataset.data[index] + ',';
            });
            csv += '\n';
        });

        var hiddenElement = document.createElement('a');
        hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
        hiddenElement.target = '_blank';
        hiddenElement.download = 'estadisticas_compras.csv';
        hiddenElement.click();
    });
    </script>
</body>

</html>