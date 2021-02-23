<?php

include_once 'Database.php';

class Autocompletar extends Database{

    function buscar($texto){
        $res = array();
        $query = $this->connect()->prepare("SELECT * FROM med_homeopaticos WHERE descrip_med_hom LIKE :texto");
        $query->execute(['texto' => $texto . '%']);

        if($query->rowCount()){
            while($r = $query->fetch()){
                array_push($res, $r['descrip_med_hom']);
            }
        }
        return $res;
    }
}

?>