<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    // Cabecera de página
    function Header()
    {
        $this->Image('../imagenes/12.jpeg', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Reporte Personal', 0, 0, 'C');
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

require('conexion.php');
$consulta = "SELECT per.idpersonal,per.fecha_ingresoP,concat(' ',p.apellidos,p.nombres) as personal,r.nombre_rol from personales per
            INNER JOIN personas p on p.dni=per.fk_dniPE
            INNER JOIN roles r on r.idrol=per.fk_idrol; ";
$resultado = $conexion->query($consulta);

// Create new PDF instance
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Table header
$pdf->SetX(5);
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Fecha Ingreso', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Personal', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Rol', 1, 1, 'C', true);

// Table data
$pdf->SetFont('Arial', '', 12);
while ($row = $resultado->fetch_assoc()) {
    $pdf->SetX(5);
    $pdf->Cell(30, 10, $row['idpersonal'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['fecha_ingresoP'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['personal'], 1, 0, 'C');
    $pdf->Cell(50, 10, $row['nombre_rol'], 1, 1, 'C');
}

$pdf->Output();
?>