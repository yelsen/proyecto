<?php
require('../modelo/fpdf/fpdf.php');
require('../modelo/conexion.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $this->Image('../imagenes/12.jpeg', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        // $this->Cell(30, 10, 'Reporte', 0, 0, 'C');
        $this->Ln(5);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Función para generar reporte de compras
    function generarReporte($titulo, $fecha_desde, $fecha_hasta, $resultado)
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, $titulo, 0, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, "Desde: $fecha_desde                          Hasta: $fecha_hasta", 0, 1, 'C');
        $this->Ln(5);

        // Encabezados de la tabla
        $this->SetX(5);
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial', 'B', 12);

        $this->Cell(40, 10, 'Tipo', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Numero', 1, 0, 'C', true);          
        $this->Cell(30, 10, 'RUC', 1, 0, 'C', true);        
        $this->Cell(40, 10, 'Proveedor', 1, 0, 'C', true);        
        $this->Cell(25, 10, 'Empresa', 1, 0, 'C', true);        
        $this->Cell(25, 10, 'Monto', 1, 1, 'C', true);

        // Cuerpo de la tabla
        $this->SetFont('Arial', '', 10);
        $total_sum = 0;
        while ($row = $resultado->fetch_assoc()) {
            $this->SetX(5);
            $this->Cell(40, 10, $row['tipo_comprobante'], 1, 0, 'C');
            $this->Cell(40, 10, $row['num_comprobanteC'], 1, 0, 'C');
            $this->Cell(30, 10, $row['RUC'], 1, 0, 'C'); 
            $this->Cell(40, 10, $row['proveedor'], 1, 0, 'C');
            $this->Cell(25, 10, $row['nombre_empresa'], 1, 0, 'C');
            $this->Cell(25, 10, 'S/.' . number_format($row['monto_ingresoC'], 2), 1, 1, 'R');   
            $total_sum += $row['monto_ingresoC'];
        }

        // Total
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(140, 10, 'Total', 1, 0, 'R', true);
        $this->Cell(60, 10, 'S/.' . number_format($total_sum, 2), 1, 1, 'R', true);

        $this->Output();
    }
    function generarReportePagoPersonal($titulo, $fecha_desde, $fecha_hasta, $resultado)
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, $titulo, 0, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, "Desde: $fecha_desde                          Hasta: $fecha_hasta", 0, 1, 'C');
        $this->Ln(5);

        // Encabezados de la tabla
        $this->SetX(5);
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial', 'B', 12);

        $this->Cell(40, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(40, 10, 'DNI', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Personal', 1, 0, 'C', true);          
        $this->Cell(30, 10, 'Rol', 1, 0, 'C', true);        
        $this->Cell(40, 10, 'Monto Pagado', 1, 0, 'C', true);    

        // Cuerpo de la tabla
        $this->SetFont('Arial', '', 10);
        $total_sum = 0;
        while ($row = $resultado->fetch_assoc()) {
            $this->SetX(5);
            $this->Cell(40, 10, $row['idpago'], 1, 0, 'C');
            $this->Cell(40, 10, $row['dni'], 1, 0, 'C');
            $this->Cell(30, 10, $row['personal'], 1, 0, 'C'); 
            $this->Cell(40, 10, $row['nombre_rol'], 1, 0, 'C');
            $this->Cell(25, 10, 'S/.' . number_format($row['monto_pagoP'], 2), 1, 1, 'R');   
            $total_sum += $row['monto_pagoP'];
        }

        // Total
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(140, 10, 'Total', 1, 0, 'R', true);
        $this->Cell(60, 10, 'S/.' . number_format($total_sum, 2), 1, 1, 'R', true);

        $this->Output();
    }

    // Función para generar reporte de ventas
    function generarReporteVentas($titulo, $fecha_desde, $fecha_hasta, $resultado)
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, $titulo, 0, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, "Desde: $fecha_desde   Hasta: $fecha_hasta", 0, 1, 'C');
        $this->Ln(5);

        // Encabezados de la tabla
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(50, 10, 'Fecha de Venta', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Categoría', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Cantidad', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Monto', 1, 1, 'C', true);

        // Cuerpo de la tabla
        $this->SetFont('Arial', '', 12);
        $total_sum = 0;
        while ($row = $resultado->fetch_assoc()) {
            $this->Cell(50, 10, $row['fecha_venta'], 1, 0, 'C');
            $this->Cell(50, 10, $row['categoria'], 1, 0, 'C');
            $this->Cell(40, 10, $row['cantidad'], 1, 0, 'C');
            $this->Cell(50, 10, 'S/.' . number_format($row['monto_venta'], 2), 1, 1, 'R');
            $total_sum += $row['monto_venta'];
        }

        // Total
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(140, 10, 'Total', 1, 0, 'R', true);
        $this->Cell(50, 10, 'S/.' . number_format($total_sum, 2), 1, 1, 'R', true);

        $this->Output();
    }

    function generarReporteCatalogo($titulo, $resultado)
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, $titulo, 0, 1, 'C');
        $this->Ln(5);

        // Encabezados de la tabla
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(50, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Sabor', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Presentacion', 1, 0, 'C', true);

        // Cuerpo de la tabla
        $this->SetFont('Arial', '', 12);
        $total_sum = 0;
        while ($row = $resultado->fetch_assoc()) {
            $this->Cell(50, 10, $row['idcatalogo'], 1, 0, 'C');
            $this->Cell(50, 10, $row['sabor'], 1, 0, 'C');
            $this->Cell(50, 10, $row['presentacion'], 1, 0, 'C');

        }

        $this->Output();
    }




}

// Controlador para generar reportes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reporte_id = $_POST['reporte_id'];
    $fecha_desde = $_POST['txtDe'];
    $fecha_hasta = $_POST['txtHasta'];

    // Selección de reporte
    switch ($reporte_id) {
        case 1:
            $titulo = "Reporte de Compras";
            $query = "SELECT tipo_comprobante, num_comprobanteC, RUC, 
                        dni, concat_ws(' ',apellidos, nombres) as 'proveedor', nombre_empresa,monto_ingresoC
                        from compras as c left join detalle_compras as d on c.idcompra=d.fk_idcompra
                        inner join insumos as i on i.idinsumo=d.fk_idinsumo
                        inner join tipo_comprobantes as t on t.idtipo_comprobante=c.fk_idtipo_comprobante
                        inner join proveedores as p on p.idproveedor=c.fk_idproveedor
                        inner join empresas as e on e.idempresa=p.fk_idempresa
                        inner join personas as pe on pe.dni=p.fk_dniP
                        WHERE fecha_ingresoC BETWEEN ? AND ?";
            break;

        case 2:
            $titulo = "Reporte de Ventas";
            $query = "SELECT v.fecha_venta, cat.categoria, dv.cantidad, v.monto_venta 
                      FROM detalle_ventas dv 
                      INNER JOIN ventas v ON v.idventa = dv.fk_idventa
                      INNER JOIN productos p ON p.idproducto = dv.fk_idproducto
                      INNER JOIN catalogos c ON c.idcatalogo = p.fk_idcatalogo
                      INNER JOIN categorias cat ON cat.idcategoria = c.fk_idcategoria 
                      WHERE v.fecha_venta BETWEEN ? AND ?";
            break;
        case 3:
            $titulo = "Reporte de Pagos Personal";
            $query = "SELECT pe.dni,concat(' ',pe.apellidos,pe.nombres), r.nombre_rol,p.monto_pagoP FROM pagos p 
                        INNER JOIN personales per on per.idpersonal=p.fk_idpersonal
                        INNER JOIN personas pe on pe.dni=per.fk_dniPE
                        INNER JOIN roles r on r.idrol=per.fk_idrol 
                        WHERE p.fecha_pagoP BETWEEN ? AND ?";
            break;

        default:
            die("Tipo de reporte no válido");
    }

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ss", $fecha_desde, $fecha_hasta);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Generar PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();


    switch ($reporte_id) {
        case 1:
            $pdf->generarReporte($titulo, $fecha_desde, $fecha_hasta, $resultado);
            break;

        case 2:
            $pdf->generarReporteVentas($titulo, $fecha_desde, $fecha_hasta, $resultado);
            break;
        case 3:
            $pdf->generarReportePagoPersonal($titulo, $fecha_desde, $fecha_hasta, $resultado);
            break;
        default:
            die("Tipo de reporte no válido");
    }

    $stmt->close();
    $conexion->close();
    exit;
}
?>
