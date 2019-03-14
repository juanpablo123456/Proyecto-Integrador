<?php
include "core/autoload.php";
include "admin/core/modules/index/model/BuyData.php";
include "admin/core/modules/index/model/BuyProductData.php";
include "admin/core/modules/index/model/ProductData.php";
include "admin/core/modules/index/model/ClientData.php";
include "admin/core/modules/index/model/UnitData.php";
include "admin/core/modules/index/model/ConfigurationData.php";
require('fpdf/fpdf.php');

class PDF extends FPDF
{
//Cabecera de página
   function Header()
   {
		//Logo
    
		//Arial bold 15
		$this->SetFont('Arial','B',15);
		//Movernos a la derecha
		$this->Cell(80);
		//Título
		$this->Cell(40,10,'Inventario');
		//Salto de línea
		$this->Ln(20);
      
   }
   
   //Pie de página
   function Footer()
   {
	
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   }

      //Tabla coloreada
	function TablaColores($header)
	{
		$categories = ProductData::getAll();
		//Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(0, 191, 255);
		$this->SetTextColor(0);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		//Cabecera
		$this->setY(30);
		$this->setX(5);
		for($i=0;$i<count($header);$i++)
			$this->Cell(50,8,$header[$i],1,0,'C',1);
			$this->Ln();
		//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
		//Datos
			$fill=false;
		foreach($categories as $cat){
			$this->setX(5);
			$this->Cell(50,8,strtoupper($cat->name),'LR',0,'L',$fill);
			$this->Cell(50,8,strtoupper($cat->cantidad),'LR',0,'L',$fill);
			$this->Cell(50,8,"",'LR',0,'L',$fill);
			$this->Cell(50,8,"",'LR',0,'L',$fill);
			$this->Ln();
			$fill=!$fill;
		}
			
	}
}

 $pdf=new PDF();
//Títulos de las columnas
$header=array('Nombre','Cantidad','Existencia','Diferencia');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(65);
//$pdf->AddPage();


$pdf->TablaColores($header);
$pdf->Output();
?>