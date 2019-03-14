<?php
	//Agregamos la libreria para genera códigos QR
	require "phpqrcode/qrlib.php";
	//Importar la informacion de los scripts
	include "core/autoload.php";
	include "admin/core/modules/index/model/BuyData.php";
	include "admin/core/modules/index/model/BuyProductData.php";
	include "admin/core/modules/index/model/ProductData.php";
	include "admin/core/modules/index/model/ClientData.php";
	include "admin/core/modules/index/model/UnitData.php";
	include "admin/core/modules/index/model/ConfigurationData.php";    
	
	//Declaramos una carpeta temporal para guardar la imagenes generadas
	$dir = 'temp/';
	//Declaramos las variables globales
	$service = BuyData::getByCode($_GET["code"]);
	$products = BuyProductData::getAllByBuyId($service->id);
    $client = ClientData::getById($service->client_id);
	
	//Si no existe la carpeta la creamos
	if (!file_exists($dir))
        mkdir($dir);
	
        //Declaramos la ruta y nombre del archivo a generar
	$filename = $dir.'test.png';

        //Parametros de Condiguración
	
	$tamaño = 20; //Tamaño de Pixel
	$level = 'L'; //Precisión Baja
	$framSize = 1; //Tamaño en blanco
	$contenido = " Nombre: ".$client->getFullname()."\n"; //Texto
	$contenido .="Detalles de la compra: \n";
	foreach($products as $itemx){
        $item = $itemx->getProduct();
        $mtx=null;
            
         $contenido .="Cantidad: ".$itemx->q."\n";
         $contenido .="Tipo: ".$item->getUnit()->name."\n";
         $contenido .="Nombre Producto: ".$item->name."\n";
         $contenido .="Precio :".number_format($item->price,2,".",",");
    }

        //Enviamos los parametros a la Función para generar código QR 
	QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 
	
        //Mostramos la imagen generada
	echo '<img src="'.$dir.basename($filename).'" /><hr/>';  
?>