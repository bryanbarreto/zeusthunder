<?php

    include '../classe/bd.class.php';
    include '../classe/cadaluno.class.php';

    $objeto = new Aluno();
    $bd = new Bd();
    
    $ajax = $_REQUEST['ajax'];

    try{
        $bd->conectar();
    }catch(Exception $e){
        $json = $e->getMessage();
        echo json_encode($json);
    }

?>