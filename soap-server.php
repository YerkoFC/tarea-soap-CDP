<?php 

/*  Libreria NuSoap */
include_once 'lib/nusoap.php';
/* Namespace */
$nameSpace = "urn:webService";
/* Soap server */
$service = new soap_server(); 
/* Configuración WSDL */
$service->configureWSDL("Proyecto Soap - CDP 2020", $nameSpace);

$service->schemaTargetNamespace = $nameSpace;

/* Registro de funciones del WS */
/* 
* @param Nombre de la funcion
* @param Array con parametros de entrada
* @param Array con el o los valores de retorno de la funcion
* @param Namespace
*/

/* Funcion para tarea */

// $service->register('tareaSoap',
// 	array('nameFile' => 'xsd:string',  'mimeType' => 'xsd:string', 'file' => 'xsd:base64Binary'),
// 	array('nameFileOut' => 'xsd:string', 'mimeTypeOut' => 'xsd:string', 'fileOut' => 'xsd:base64Binary'),
// 	$nameSpace);

// function tareaSoap($file, $cantidad) {
	
// 		file_get_contents transmite o guarda un fichero entero a una cadena.
// 		Como parametro recibe la ruta en la cual se ubica el archivo a leer, 
// 		el cual en este caso sería './holamundo.b64'
	
// 	// $result = '';
// 	// $cant = (int)$cantidad;
// 	$data = file_get_contents($file);
// 	// $dataSplited = explode(' ', $data);
// 	// for ($i=0; $i < $cant ; $i++) { 
// 	// 	$result .=  $dataSplited[$i] . ' ';
// 	// }
// 	// return base64_decode($data);
// 	return $data;

	
// }


$service->register('pruebaCsv',
	array('nameFile' => 'xsd:string', 'mimeType' => 'xsd:string', 'file' => 'xsd:base64Binary'),
	array('paramOut' => 'xsd:base64Binary'),
	$nameSpace);

function pruebaCsv($nameFile, $mimeType, $file) {
	
	$data = file_get_contents($nameFile);
	
	$fileDecoded = base64_decode($data);
	

	$base64File = base64_encode($fileDecoded);
	
	return $base64File ;
	
	
	// $data = file_get_contents($paramIn);
	// $datab64 = base64_decode($data);
	// $dataSplited = explode(';', $datab64);
	// $promedio = 0.0;
	// $contador = 0;
	// for ($i=0; $i < sizeof($dataSplited); $i++) { 
	// 	if(strlen($dataSplited[$i]) <= 3) {
	// 		$promedio += (int)$dataSplited[$i];
	// 		$contador += 1;
	// 	}
	// }
	// $resultado =  $promedio / $contador;
	// return 'Promedio: ' . $resultado;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$service->service(file_get_contents("php://input"));


?>