<?php

require_once('PHPExcel/IOFactory.php');

function getMenuArray($menuFilePath)
{
   $objPHPExcel = PHPExcel_IOFactory::load($menuFilePath);
   $sheetData = $objPHPExcel->getActiveSheet()->toArray();
   return $sheetData;
}

