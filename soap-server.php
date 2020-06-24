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



$service->register('pruebaCsv',
	array('nameFile' => 'xsd:string', 'mimeType' => 'xsd:string', 'file' => 'xsd:base64Binary'),
	array('paramOut' => 'xsd:base64Binary'),
	$nameSpace);

function pruebaCsv($nameFile, $mimeType, $file) {
	
	$data = file_get_contents($nameFile);
	
	$fileDecoded = base64_decode($data);
	

	$base64File = base64_encode($fileDecoded);
	
	return $base64File ;
	
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$service->service(file_get_contents("php://input"));


?>