<?php

    include_once('./ConnectionDB.php');
    /* 
        @param Array de strings con rut y puntajes 
        @return Array de strings sin espacios en blanco antes ni despues
    */
    function trimPtjes($puntajes) {
        for ($i = 0; $i < sizeof($puntajes) ; $i++) { 
            $puntajes[$i] = trim($puntajes[$i]);
        }
        return $puntajes;
    }

    /*
        @param String con ruts y puntajes
        @return Array con los ruts y puntajes ya separados 
    */
    function manejaCsvPtjs($puntajes) {

        $ptjsSplit = explode("\n", $puntajes);
        $ptjsSplit = trimPtjes($ptjsSplit);
        $results = array();

        for ($i=0; $i < sizeof($ptjsSplit); $i++) { 
            array_push($results,  explode(';', $ptjsSplit[$i]) );
        }

        return $results;
    }

    /*
        @param Ruta del archivo .json que contiene la informacion de todas las carreras
        @return Informacion de las carreras en una tipo de dato de PHP (array)
    */
    function leeJson($rutaArchivoJson) {
        $contenido = file_get_contents($rutaArchivoJson);
        $con = utf8_decode($contenido);
        $datos = json_decode($con, true);
        return $datos;
    }

    /*
        @param Array con la informacion de cada carrera
        @return Booleano que indica si cumple con el filtro o no
    */
    function filtrarPtje450($puntajes) {
        $promedio = (($puntajes[3] + $puntajes[4]) / 2 );
        if($promedio >= 450) {
            return true;
        } else {
            return false;
        }
    }

    /*
        @param Array con la info de una carrera determinada
        @param Array con el rut y los puntajes de un postulante
    */
    function pondera($infoCarreras, $puntajes) {
        $nem  = (float)$puntajes[1] * ($infoCarreras["nem"] / 100);
        $rank = (float)$puntajes[2] * ($infoCarreras["ranking"] / 100);
        $mate = (float)$puntajes[3] * ($infoCarreras["lenguaje"] / 100);
        $leng = (float)$puntajes[4] * ($infoCarreras["matematica"] / 100);
        $hist = (float)$puntajes[5] * ($infoCarreras["cienciasHistoria"] / 100);
        $cien = (float)$puntajes[6] * ($infoCarreras["cienciasHistoria"] / 100);

        if($hist >= $cien) {
            $pond = $nem + $rank + $mate + $leng + $hist;
            return array($puntajes[0], $pond);
        } else {
            $pond = $nem + $rank + $mate + $leng + $cien;
            return array($puntajes[0], $pond);
        }
    }

    /*
        @param Array con info de carreras
        @return Array que se utilizará para que se ingresen los postulantes finales por cada carrera 
    */
    function llenarCarreras($infoCarreras) {
        $arrayCarreras = array();

        // Son 28 el total de carreras disponibles
        for ($i=0; $i < 28; $i++) {

            array_push($arrayCarreras, array(
                "codigo" => $infoCarreras[$i]["codigo"],
                "vacantes" => $infoCarreras[$i]["vacantes"],
                "postulantes" => array()));
        }
        
        return $arrayCarreras;

    }


    /* 
        Ordena un array multidimensional por un valor en específico
    */
    function ordenaPorPtje($a, $b) {
        return $b[1] - $a[1];
    }

    /* 
        @param Array que contiene info de cada carrera y un sub array con los respectivos postulantes
        @param Array que contiene los ruts y los ptjs ponderados de cada postulante
    */
    function ingresaPostulante(&$postulantesPorCarrera, $puntajes){
    
        // Si aún quedan cupos para la carrera, ingresa un nuevo postulante y ordena el array
        if($postulantesPorCarrera["vacantes"] > sizeof($postulantesPorCarrera["postulantes"])) {
            
            array_push($postulantesPorCarrera["postulantes"],  $puntajes);
            usort($postulantesPorCarrera["postulantes"], 'ordenaPorPtje');
            // arsort($postulantesPorCarrera["postulantes"]);

        } else {
            // arsort($postulantesPorCarrera["postulantes"]);
            //usort($postulantesPorCarrera["postulantes"], 'ordenaPorPtje');
            if( $puntajes[1] > end($postulantesPorCarrera["postulantes"])) {
                array_pop($postulantesPorCarrera["postulantes"]);
                array_push($postulantesPorCarrera["postulantes"], $puntajes);
                // arsort($postulantesPorCarrera["postulantes"]);
                usort($postulantesPorCarrera["postulantes"], 'ordenaPorPtje');

            } 

        }
    }

    /* Guarda todo el contenido de un archivo en $puntajes */
    $puntajes = file_get_contents("./archivosPrueba/puntajes.b64");
    /* Decodifica un string en base 64 a un string normal */
    $ptjsDecoded = base64_decode($puntajes);
    $misPuntajes = manejaCsvPtjs($ptjsDecoded);
    $personasFiltradas = array();
    $Carreras =  leeJson('./infoCarreras.json');

    $postulantesPorCarrera = llenarCarreras($Carreras);;
    //var_dump($Carreras);
   
    for ($i=0; $i < 100 ; $i++) {

        if(filtrarPtje450($misPuntajes[$i])) {
            $ponderado = pondera($Carreras[0], $misPuntajes[$i]);
            ingresaPostulante($postulantesPorCarrera[0], $ponderado);

        }


        // if(filtrarPtje450($misPuntajes[$i])) {    
            
        //     $postulante = filtrarPorUltimo($Carreras[0], $misPuntajes[$i]);
        //     var_dump($postulante);
        //     //ingresaPostulante($postulantesPorCarrera[0], $postulante);            
            
        // } 
    }

    /* Muestra los postulantes de la primera carrera */
    var_dump($postulantesPorCarrera[0]);
   
    


    
?>