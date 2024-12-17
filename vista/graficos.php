<?php
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
$colores = ['#4C51BF', '#ED64A6', '#48BB78', '#ECC94B', '#ED8936', '#9F7AEA', '#667EEA'];
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
        'borderColor' => $colores[$index % count($colores)],
        'backgroundColor' => $colores[$index % count($colores)],
        'tension' => 0.1
    );
}

$datosJSON = json_encode($datasets);
$fechasJSON = json_encode($fechas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Compras</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Estadísticas de Compras por Empresa</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <form action="" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio:</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>" class="mt-1 block w-full pl-10 pr-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">Fecha de fin:</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin; ?>" class="mt-1 block w-full pl-10 pr-3 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <canvas id="myChart" height="400"></canvas>
        </div>
    </div>

    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $fechasJSON; ?>,
            datasets: <?php echo $datosJSON; ?>
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Estadísticas de Compras por Empresa',
                    font: {
                        size: 18
                    }
                },
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total de Compras'
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha de Compra'
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            elements: {
                line: {
                    tension: 0.3
                }
            }
        }
    });
    </script>
</body>
</html>