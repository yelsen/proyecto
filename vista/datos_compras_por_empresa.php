<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "tu_contraseña", "tu_base_de_datos");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener compras agrupadas por empresa y fecha
$sql = "SELECT 
            c.fecha_ingresoC AS fecha_compras,
            e.nombre_empresa AS empresa,
            SUM(c.monto_ingresoC) AS total_compras
        FROM compras AS c
        INNER JOIN proveedores AS p ON p.idproveedor = c.fk_idproveedor
        INNER JOIN empresas AS e ON e.idempresa = p.fk_idempresa
        WHERE c.cond_comp = 0
        GROUP BY e.nombre_empresa, c.fecha_ingresoC";

$result = $conexion->query($sql);

// Preparar datos para Chart.js
$data = [];
$fecha_compras = [];
$total_compras = [];


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empresa = $row['empresa'];
        $fecha = $row['fecha_compras'];
        $total = $row['total_compras'];

        // Organizar datos por empresa
        if (!isset($data[$empresa])) {
            $data[$empresa] = [];
        }
        $data[$empresa][] = [
            'fecha' => $fecha,
            'total' => $total,
        ];
    }
}

// Enviar datos como JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
