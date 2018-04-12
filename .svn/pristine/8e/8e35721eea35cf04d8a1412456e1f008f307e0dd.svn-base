<?php

/**
 * get excel column string (A,B,C,..AA,AB)
 * limit sampai 676
 * @param int column number 0 base
 */
function getColumnString($number) {
    $number = $number + 1; // jadikan base 1
    if ($number > 26) {
        $char1 = intval($number / 26);
        $char2 = $number % 26;
        $char = chr($char1 + 64) . chr($char2 + 64);
    } else {
        $char = chr($number + 64);
    }
    return $char;
}

function align($a) {
    switch ($a) {
        case 'center':
            $align = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            break;
        case 'left':
            $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            break;
        case 'right':
            $align = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            break;
        case 'justify':
            $align = PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY;
            break;
        default :
            $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
    }
    return $align;
}

function valign($v) {
    switch ($v) {
        case 'top':
            $valign = PHPExcel_Style_Alignment::VERTICAL_TOP;
            break;
        case 'bottom':
            $valign = PHPExcel_Style_Alignment::VERTICAL_BOTTOM;
            break;
        case 'center':
            $valign = PHPExcel_Style_Alignment::VERTICAL_CENTER;
            break;
        case 'justify':
            $valign = PHPExcel_Style_Alignment::VERTICAL_JUSTIFY;
            break;
        default :
            $valign = PHPExcel_Style_Alignment::VERTICAL_TOP;
    }
    return $valign;
}

// End of file Excel.php
