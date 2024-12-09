<?php

function numtoletras($xcifra)
{
    $xarray = array(
        0 => "CERO",
        1 => "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        10 => "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        20 => "VEINTE", "VEINTIUNO", "VEINTIDOS", "VEINTITRES", "VEINTICUATRO", "VEINTICINCO", "VEINTISEIS", "VEINTISIETE", "VEINTIOCHO", "VEINTINUEVE",
        30 => "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA",
        100 => "CIEN", "CIENTO", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS"
    );

    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    
    if ($xpos_punto === false) {
        $xpos_punto = $xlength;
    } else {
        $xdecimales = substr($xcifra, $xpos_punto + 1, 2);
        $xaux_int = substr($xcifra, 0, $xpos_punto);
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT);
    $xcadena = "";
    
    // Parte entera
    for ($i = 0; $i < 9; $i++) {
        $xposicion = substr($XAUX, $i * 2, 2);
        $xposicion = trim($xposicion);
        if ($xposicion == "00") {
            continue;
        }
        if ($i == 0) {
            $xcadena = $xarray[intval($xposicion)];
        } elseif ($i == 1) {
            $xcadena .= " " . (($xcifra == 100) ? "CIEN" : (($xposicion > 0) ? $xarray[intval($xposicion)] . " MIL" : ""));
        } elseif ($i == 2) {
            $xcadena .= " " . (($xposicion == 1) ? "UN MILLON" : (($xposicion > 0) ? $xarray[intval($xposicion)] . " MILLONES" : ""));
        } elseif ($i == 3) {
            $xcadena .= " " . (($xposicion == 1) ? "UN BILLON" : (($xposicion > 0) ? $xarray[intval($xposicion)] . " BILLONES" : ""));
        } elseif ($i == 4) {
            $xcadena .= " " . (($xposicion == 1) ? "UN TRILLON" : (($xposicion > 0) ? $xarray[intval($xposicion)] . " TRILLONES" : ""));
        } elseif ($i == 5) {
            $xcadena .= " " . (($xposicion == 1) ? "UN CUATRILLON" : (($xposicion > 0) ? $xarray[intval($xposicion)] . " CUATRILLONES" : ""));
        } elseif ($i == 6) {
            $xcadena .= " " . (($xposicion == 1) ? "UN QUINTILLON" : (($xposicion > 0) ? $xarray[intval($xposicion)] . " QUINTILLONES" : ""));
        } elseif ($i == 7) {
            $xcadena .= " " . (($xposicion == 1) ? "UN SEXTILLON" : (($xposicion > 0) ? $xarray[intval($xposicion)] . " SEXTILLONES" : ""));
        } elseif ($i == 8) {
            $xcadena .= " " . (($xposicion == 1) ? "UN SEPTILLON" : (($xposicion > 0) ? $xarray[intval($xposicion)] . " SEPTILLONES" : ""));
        }
    }

    if (trim($xcadena) == "") {
        $xcadena = "CERO";
    }

    // Parte decimal (centavos)
    if ($xdecimales != "00") {
        $xcadena .= " CON " . $xdecimales . "/100 SOLES";
    } else {
        $xcadena .= " CON 00/100 SOLES";
    }

    return $xcadena;
}


?>