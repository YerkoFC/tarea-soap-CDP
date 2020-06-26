<?php

    $miArray = array( 
        array(), 
        "postulantes" => array( 
            array("19547803", 561),
            array("11547803", 661),
            array("12547803", 761),
            array("12447803", 771),
            array("13647803", 531),
            array("13747803", 121),
        )
    );

    function sortByScore($a, $b) {
        return $b[1] - $a[1];
    }
    usort($miArray["postulantes"], 'sortByScore');
    var_dump($miArray);    
?>