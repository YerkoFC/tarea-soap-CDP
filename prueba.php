<?php

    $data = file_get_contents('./prueba.b64');
    $dataDecoded = base64_decode($data);
    $infoSplited = explode("\n", $dataDecoded);
    $ptjs = array();

    for ($i=0; $i<sizeof($infoSplited) - 1; $i++) { 
        $ptje = explode(';',$infoSplited[$i]);
        array_push($ptjs ,trim($ptje[1]));
    }

    $suma = 0;
    $cont = 0;
    for ($i=0; $i < sizeof($ptjs); $i++) { 
        $suma += (int)$ptjs[$i];
        $cont += 1;
    }

    echo $suma / $cont
    

?>