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
        $this->Cell(30, 10, 'Reporte Productos', 0, 0, 'C');
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
$consulta = "SELECT cat.idcatalogo,s.sabor,pre.presentacion from catalogos cat 
             INNER JOIN sabores s on s.idsabor=cat.fk_idsabor
             INNER JOIN presentaciones pre on pre.idpresentacion=cat.fk_idpresentacion; ";
$resultado = $conexion->query($consulta);

// Create new PDF instance
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Table header
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(70, 10, 'Sabor', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Presentacion', 1, 1, 'C', true);

// Table data
$pdf->SetFont('Arial', '', 12);
while ($row = $resultado->fetch_assoc()) {
    $pdf->Cell(60, 10, $row['idcatalogo'], 1, 0, 'C');
    $pdf->Cell(70, 10, $row['sabor'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['presentacion'], 1, 1, 'C');
}

$pdf->Output();
?>